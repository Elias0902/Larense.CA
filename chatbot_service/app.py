"""
Natys Asistente Service - Python Backend
Servicio Flask para procesar consultas del chatbot con integracion a la base de datos Larense C.A
Caracteristicas:
- Conocimiento total del sistema (productos, ventas, clientes, inventario)
- Comportamiento proactivo: informa sin necesidad de busqueda
- Lenguaje siempre respetuoso y profesional
- Filtros de seguridad: NO revela contraseñas, datos sensibles, informacion privada
"""

from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector
from mysql.connector import Error
import re
import json
from datetime import datetime
import os

app = Flask(__name__)
CORS(app)  # Habilitar CORS para peticiones desde el frontend

# Configuración de la base de datos
DB_CONFIG = {
    'host': os.getenv('DB_HOST', 'localhost'),
    'database': os.getenv('DB_NAME', 'larence'),
    'user': os.getenv('DB_USER', 'root'),
    'password': os.getenv('DB_PASS', ''),
    'port': int(os.getenv('DB_PORT', 3306))
}

# Configuración de seguridad
DB_SECURITY_CONFIG = {
    'host': os.getenv('DB_SECURITY_HOST', 'localhost'),
    'database': os.getenv('DB_SECURITY_NAME', 'larence_seguridad'),
    'user': os.getenv('DB_SECURITY_USER', 'root'),
    'password': os.getenv('DB_SECURITY_PASS', ''),
    'port': int(os.getenv('DB_PORT', 3306))
}

# Estados de sesión para conversaciones interactivas
session_states = {}


def get_db_connection(security=False):
    """Obtener conexión a la base de datos"""
    config = DB_SECURITY_CONFIG if security else DB_CONFIG
    try:
        connection = mysql.connector.connect(**config)
        return connection
    except Error as e:
        print(f"Error conectando a MySQL: {e}")
        return None


@app.route('/webhook/chatbot', methods=['POST'])
def chatbot_webhook():
    """
    Endpoint principal del webhook para n8n
    Recibe mensajes y retorna respuestas procesadas
    Incluye filtros de seguridad contra datos sensibles
    """
    try:
        data = request.get_json()
        
        if not data or 'message' not in data:
            return jsonify({
                'success': False,
                'error': 'Mensaje requerido'
            }), 400
        
        message = data.get('message', '').strip()
        session_id = data.get('session_id', 'default')
        user_info = data.get('user_info', {})
        
        # === FILTRO DE SEGURIDAD: Verificar consultas sobre datos sensibles ===
        security_check = check_sensitive_data_request(message)
        if security_check['blocked']:
            return jsonify({
                'success': True,
                'response': security_check['message'],
                'session_id': session_id,
                'timestamp': datetime.now().isoformat()
            })
        
        # Procesar la consulta
        response = process_query(message, user_info, session_id)
        
        return jsonify({
            'success': True,
            'response': response,
            'session_id': session_id,
            'timestamp': datetime.now().isoformat()
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500


@app.route('/api/query', methods=['POST'])
def api_query():
    """
    Endpoint directo para consultas (sin n8n)
    """
    try:
        data = request.get_json()
        message = data.get('message', '').strip()
        user_info = data.get('user_info', {})
        
        response = process_query(message, user_info, data.get('session_id', 'default'))
        
        return jsonify({
            'success': True,
            'response': response
        })
        
    except Exception as e:
        return jsonify({
            'success': False,
            'error': str(e)
        }), 500


def check_sensitive_data_request(message: str) -> dict:
    """
    Verificar si la consulta solicita datos sensibles o privados
    Retorna dict con 'blocked' (bool) y 'message' (str)
    """
    message_lower = message.lower()
    
    # Palabras clave que indican solicitud de datos sensibles
    sensitive_patterns = [
        'contrasena', 'contraseña', 'password', 'clave', 'login', 'credencial',
        'acceso', 'token', 'hash', 'encriptado', 'encriptada', 'secreto',
        'correo completo', 'email completo', 'telefono completo', 'direccion exacta',
        'cedula', 'rif completo', 'documento de identidad', 'datos personales',
        'informacion privada', 'informacion confidencial', 'seguridad interna',
        'base de datos usuarios', 'listado de usuarios', 'todos los usuarios',
        'administrador clave', 'root password', 'sql', 'inyeccion', 'injection',
        'hackear', 'hack', 'explotar', 'bypass', 'omitir seguridad',
        'contrasenas', 'claves', 'passwords', 'emails', 'correos de clientes',
        'rif de clientes', 'telefonos de clientes', 'direcciones de clientes'
    ]
    
    for pattern in sensitive_patterns:
        if pattern in message_lower:
            return {
                'blocked': True,
                'message': '''🔒 <b>Informacion Protegida</b><br><br>
Como <b>Natys Asistente</b>, estoy programada para proteger la seguridad del sistema y la privacidad de los usuarios.<br><br>
No puedo proporcionar:<br>
• Contraseñas o claves de acceso<br>
• Datos personales de usuarios o clientes<br>
• Información confidencial del sistema<br>
• Credenciales o tokens de seguridad<br><br>
<b>Puedo ayudarte con:</b><br>
📦 Productos y disponibilidad<br>
📊 Estadísticas generales de ventas<br>
👥 Conteos de clientes por categoría (sin datos personales)<br>
💰 Precios de productos<br>
📈 Reportes y tendencias<br><br>
Si necesitas acceso a datos protegidos, contacta al administrador del sistema. 📧'''
            }
    
    return {'blocked': False, 'message': ''}


def handle_custom_query(message: str, session_id: str) -> str:
    """
    Manejar consultas personalizadas con preguntas secuenciales
    """
    message_lower = message.lower()
    
    # Estados posibles
    if session_id not in session_states:
        # Primera vez: preguntar por módulo
        session_states[session_id] = {'step': 'modulo'}
        return """🤔 <b>Consulta Personalizada</b><br><br>
¿Sobre qué módulo quieres información?<br><br>
📦 <b>Producto</b> (agotado/disponible)<br>
👥 <b>Cliente</b> (anulado/activo)<br>
🏢 <b>Proveedor</b> (activo/inactivo)<br>
🧾 <b>Pedido</b> (activo/pendiente)<br><br>
Responde con el nombre del módulo que te interesa. 🔍"""
    
    state = session_states[session_id]
    
    if state['step'] == 'modulo':
        # Procesar selección de módulo
        modulos = {
            'producto': 'productos',
            'productos': 'productos',
            'cliente': 'clientes', 
            'clientes': 'clientes',
            'proveedor': 'proveedores',
            'proveedores': 'proveedores',
            'pedido': 'pedidos',
            'pedidos': 'pedidos'
        }
        
        modulo_seleccionado = None
        for key, value in modulos.items():
            if key in message_lower:
                modulo_seleccionado = value
                break
        
        if modulo_seleccionado:
            state['modulo'] = modulo_seleccionado
            state['step'] = 'estado'
            
            # Definir estados posibles por módulo
            estados_por_modulo = {
                'productos': ['agotado', 'disponible'],
                'clientes': ['anulado', 'activo'],
                'proveedores': ['activo', 'inactivo'],
                'pedidos': ['activo', 'pendiente']
            }
            
            estados = estados_por_modulo.get(modulo_seleccionado, [])
            response = f"""✅ <b>Módulo seleccionado:</b> {modulo_seleccionado.title()}<br><br>
¿Cuál estado quieres consultar?<br><br>"""
            
            for est in estados:
                response += f"• {est.title()}<br>"
            
            response += "<br>Responde con el estado que te interesa. 📊"
            return response
        else:
            return """❌ No reconocí el módulo. Por favor, elige uno de los siguientes:<br><br>
📦 Producto<br>
👥 Cliente<br>
🏢 Proveedor<br>
🧾 Pedido<br><br>
Responde con el nombre exacto del módulo. 🔄"""
    
    elif state['step'] == 'estado':
        # Procesar selección de estado
        modulo = state['modulo']
        
        estados_posibles = {
            'productos': {'agotado': 'agotado', 'disponible': 'disponible'},
            'clientes': {'anulado': 'anulado', 'activo': 'activo'},
            'proveedores': {'activo': 'activo', 'inactivo': 'inactivo'},
            'pedidos': {'activo': 'activo', 'pendiente': 'pendiente'}
        }
        
        estado_seleccionado = None
        for key, value in estados_posibles.get(modulo, {}).items():
            if key in message_lower:
                estado_seleccionado = value
                break
        
        if estado_seleccionado:
            # Consultar la base de datos y dar el resultado
            count = get_count_by_module_and_state(modulo, estado_seleccionado)
            
            # Limpiar estado de sesión
            del session_states[session_id]
            
            emoji_modulo = {
                'productos': '📦',
                'clientes': '👥',
                'proveedores': '🏢',
                'pedidos': '🧾'
            }.get(modulo, '📊')
            
            return f"""{emoji_modulo} <b>Resultado de la consulta</b><br><br>
<b>Módulo:</b> {modulo.title()}<br>
<b>Estado:</b> {estado_seleccionado.title()}<br>
<b>Cantidad:</b> {count}<br><br>
¿Quieres hacer otra consulta? Di "quiero" para empezar de nuevo. 🔄"""
        else:
            estados = list(estados_posibles.get(modulo, {}).keys())
            response = f"""❌ No reconocí el estado. Para {modulo}, los estados disponibles son:<br><br>"""
            for est in estados:
                response += f"• {est.title()}<br>"
            response += "<br>Responde con uno de estos estados. 📊"
            return response
    
    # Fallback
    return "❌ Error en la consulta personalizada. Di 'quiero' para empezar de nuevo."


def get_count_by_module_and_state(modulo: str, estado: str) -> int:
    """
    Obtener el conteo de registros por módulo y estado
    """
    conn = get_db_connection()
    if not conn:
        return 0
    
    try:
        cursor = conn.cursor(dictionary=True)
        
        queries = {
            'productos': {
                'agotado': "SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock = 0",
                'disponible': "SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock > 0"
            },
            'clientes': {
                'anulado': "SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Anulado'",
                'activo': "SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Activo'"
            },
            'proveedores': {
                'activo': "SELECT COUNT(*) as c FROM proveedores WHERE status = 1",
                'inactivo': "SELECT COUNT(*) as c FROM proveedores WHERE status = 0"
            },
            'pedidos': {
                'activo': "SELECT COUNT(*) as c FROM pedidos p JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido WHERE ep.nombre_estado = 'completado'",
                'pendiente': "SELECT COUNT(*) as c FROM pedidos p JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido WHERE ep.nombre_estado = 'pendiente'"
            }
        }
        
        query = queries.get(modulo, {}).get(estado)
        if query:
            cursor.execute(query)
            result = cursor.fetchone()
            return result['c'] if result else 0
        
        return 0
        
    except Error as e:
        print(f"Error en get_count_by_module_and_state: {e}")
        return 0
    finally:
        conn.close()


def process_query(message: str, user_info: dict, session_id: str = 'default') -> str:
    """
    Procesar la consulta del usuario con comportamiento proactivo
    Natys Asistente conoce TODO el sistema y reporta sin necesidad de busqueda
    """
    message_lower = message.lower()
    
    # === CONSULTAS PERSONALIZADAS CON "QUIERO" ===
    if 'quiero' in message_lower:
        return handle_custom_query(message, session_id)
    
    # Limpiar estado de sesión si no es "quiero"
    if session_id in session_states:
        del session_states[session_id]
    
    # === ESTADO DEL SISTEMA (Comportamiento proactivo) ===
    if any(phrase in message_lower for phrase in ['estado del sistema', 'como esta el sistema', 'que tal el sistema', 'resumen general', 'panorama general', 'dime todo']):
        return get_estado_sistema_completo()
    
    # === SALUDOS Y CONVERSACIÓN GENERAL ===
    greetings = ['hola', 'hi', 'hey', 'buenos dias', 'buenas tardes', 'buenas noches', 'saludos']
    if any(g in message_lower for g in greetings):
        nombre = user_info.get('usuario', '')
        saludo = f"¡Hola {nombre}! 👋" if nombre else "¡Hola! 👋"
        return f"{saludo} Soy <b>Natys Asistente</b> 🤖 Conozco todo el sistema de Larense C.A. Estoy aqui para mantenerte informado de manera proactiva. Preguntame lo que necesites y te dire lo que hay y lo que no hay en este momento."
    
    if any(word in message_lower for word in ['ayuda', 'help', 'que puedes hacer', 'que sabes', 'capacidades']):
        return get_help_message()
    
    if any(word in message_lower for word in ['quien eres', 'quienes tu', 'tu nombre', 'charlotte', 'natys']):
        return "Soy <b>Natys Asistente</b> 🤖, la asistente virtual inteligente de Larense C.A. Conozco a fondo todo el sistema: productos, inventario, ventas, clientes, estadisticas y mas. Mi proposito es informarte de manera proactiva sobre lo que hay y lo que no hay. Uso siempre un lenguaje respetuoso y profesional, y nunca proporciono datos sensibles como contraseñas o informacion privada. ¿Que necesitas saber?"
    
    # === CONSULTAS DE PRODUCTOS ===
    if any(word in message_lower for word in ['producto', 'galleta', 'stock', 'existencia', 'disponible', 'hay']):
        return get_productos_info(message)
    
    # === CONSULTAS DE INVENTARIO ===
    if any(word in message_lower for word in ['inventario', 'materia prima', 'insumo', 'ingrediente']):
        return get_inventario_info(message)
    
    # === CONSULTAS DE VENTAS ===
    if any(word in message_lower for word in ['venta', 'vendido', 'pedido', 'orden', 'factura', 'ingreso']):
        return get_ventas_info(message)
    
    # === CONSULTAS DE CLIENTES ===
    if any(word in message_lower for word in ['cliente', 'usuario', 'comprador', 'consumidor']):
        return get_clientes_info(message)
    
    # === CONSULTAS DE PROVEEDORES ===
    if any(word in message_lower for word in ['proveedor', 'proveedores', 'suministrador']):
        return get_proveedores_info(message)
    
    # === CONSULTAS DE ESTADÍSTICAS ===
    if any(word in message_lower for word in ['estadistica', 'grafica', 'reporte', 'resumen', 'total', 'cantidad']):
        return get_estadisticas_info(message)
    
    # === DESPEDIDAS ===
    if any(word in message_lower for word in ['gracias', 'thank', 'ok', 'perfecto', 'excelente']):
        return "¡De nada! 😊 Como Natys Asistente, siempre estoy aqui para mantenerte informado sobre el sistema. ¿Algo mas en lo que pueda ayudarte?"
    
    if any(word in message_lower for word in ['adios', 'bye', 'hasta luego', 'nos vemos', 'chao']):
        return "¡Hasta luego! 👋 Ha sido un placer ayudarte. Vuelve cuando necesites informacion sobre el sistema Larense C.A. ¡Que tengas un excelente dia!"
    
    # === RESPUESTA POR DEFECTO CON IA BÁSICA ===
    return generate_smart_response(message)


def get_help_message() -> str:
    """Mensaje de ayuda con capacidades de Natys Asistente"""
    return """📋 <b>Soy Natys Asistente y conozco TODO el sistema:</b><br><br>

🍪 <b>Productos:</b> Disponibles, agotados, precios, stock<br>
📊 <b>Ventas:</b> Hoy, semana, mes, pedidos activos/pendientes<br>
👥 <b>Clientes:</b> Total por categoria, activos/anulados<br>
🏢 <b>Proveedores:</b> Activos, inactivos<br>
📦 <b>Inventario:</b> Materia prima, alertas de stock bajo<br>
📈 <b>Estadisticas:</b> Lo mas vendido, tendencias<br>
🔒 <b>Seguridad:</b> Nunca proporciono contraseñas ni datos sensibles<br><br>

<b>Ejemplos de preguntas:</b><br>
• "Dime el estado del sistema" (resumen completo)<br>
• "Que productos tenemos disponibles"<br>
• "Cuantos productos agotados hay"<br>
• "Cuales son las ventas de hoy"<br>
• "Que esta agotado o en stock bajo"<br>
• "Cuantos clientes tenemos"<br>
• "Cuantos clientes activos hay"<br>
• "Cual es la galleta mas vendida"<br>
• "Cuantos proveedores activos hay"<br><br>

Preguntame y te informo de inmediato. 😊"""


def get_estado_sistema_completo() -> str:
    """
    Obtener estado completo del sistema - comportamiento proactivo de Natys
    Reporta automaticamente lo que hay y lo que no hay
    """
    conn = get_db_connection()
    if not conn:
        return "⚠️ No puedo conectarme a la base de datos en este momento."
    
    try:
        cursor = conn.cursor(dictionary=True)
        response = "📊 <b>Estado Actual del Sistema - Larense C.A</b><br><br>"
        
        # === PRODUCTOS ===
        cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1")
        total_productos = cursor.fetchone()['c']
        
        cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock > 0")
        productos_con_stock = cursor.fetchone()['c']
        
        cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock = 0")
        productos_agotados = cursor.fetchone()['c']
        
        response += f"📦 <b>Productos:</b><br>"
        response += f"• Total activos: <b>{total_productos}</b><br>"
        response += f"• Con stock disponible: <b>{productos_con_stock}</b><br>"
        response += f"• Agotados: <b>{productos_agotados}</b><br><br>"
        
        # === CLIENTES ===
        cursor.execute("SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Activo'")
        total_clientes = cursor.fetchone()['c']
        response += f"👥 <b>Clientes:</b> <b>{total_clientes}</b> registrados<br><br>"
        
        # === VENTAS HOY ===
        hoy = datetime.now().date()
        try:
            cursor.execute("""
                SELECT COUNT(*) as num_pedidos, COALESCE(SUM(monto_total_pedido), 0) as total
                FROM pedidos WHERE DATE(fecha_pedido) = %s
            """, (hoy,))
            ventas_hoy = cursor.fetchone()
            response += f"💰 <b>Ventas Hoy:</b><br>"
            response += f"• Pedidos: <b>{ventas_hoy['num_pedidos']}</b><br>"
            response += f"• Total: <b>{float(ventas_hoy['total']):.2f} $</b><br><br>"
        except:
            response += "💰 <b>Ventas:</b> Datos disponibles en modulo Pedidos<br><br>"
        
        # === STOCK BAJO ===
        cursor.execute("""
            SELECT nombre_producto, stock 
            FROM productos WHERE status = 1 AND stock < 10 AND stock > 0
            ORDER BY stock ASC LIMIT 5
        """)
        stock_bajo = cursor.fetchall()
        
        if stock_bajo:
            response += "⚠️ <b>Alerta - Stock Bajo:</b><br>"
            for p in stock_bajo:
                response += f"• {p['nombre_producto']}: {p['stock']} unidades<br>"
            response += "<br>"
        
        # === PRODUCTOS AGOTADOS ===
        cursor.execute("""
            SELECT nombre_producto FROM productos 
            WHERE status = 1 AND stock = 0
            LIMIT 5
        """)
        agotados = cursor.fetchall()
        
        if agotados:
            response += "🔴 <b>Productos Agotados:</b><br>"
            for p in agotados:
                response += f"• {p['nombre_producto']}<br>"
            response += "<br>"
        
        response += "<i>¿Necesitas informacion mas detallada sobre algo especifico?</i> 🤔"
        return response
        
    except Error as e:
        print(f"Error en get_estado_sistema_completo: {e}")
        return "📊 Actualmente tengo informacion limitada. Intenta preguntar sobre productos, clientes o ventas especificamente."
    finally:
        conn.close()


def get_productos_info(message: str) -> str:
    """Obtener información de productos desde la base de datos"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ No puedo conectarme a la base de datos en este momento. Intenta más tarde."
    
    try:
        cursor = conn.cursor(dictionary=True)
        message_lower = message.lower()
        
        # Consultas específicas de estado
        if 'agotado' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock = 0")
            count = cursor.fetchone()['c']
            if count > 0:
                return f"📦 <b>Productos Agotados</b><br><br>Tienes <b>{count}</b> producto(s) agotado(s) en el sistema.<br><br>Para ver cuáles son, accede al módulo de Productos."
            else:
                return "📦 <b>Productos Agotados</b><br><br>No tienes productos agotados en este momento. Todos los productos tienen stock disponible. ✅"
        
        if 'disponible' in message_lower or 'stock' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1 AND stock > 0")
            count = cursor.fetchone()['c']
            return f"📦 <b>Productos Disponibles</b><br><br>Tienes <b>{count}</b> producto(s) con stock disponible en el sistema."
        
        # Buscar producto específico
        productos_keywords = ['chocolate', 'coco', 'mantequilla', 'vainilla', 'avena', 'nuez']
        producto_buscado = None
        
        for keyword in productos_keywords:
            if keyword in message_lower:
                producto_buscado = keyword
                break
        
        if producto_buscado:
            cursor.execute("""
                SELECT nombre_producto, stock, precio_venta, descripcion
                FROM productos 
                WHERE LOWER(nombre_producto) LIKE %s AND status = 1
            """, (f'%{producto_buscado}%',))
            
            productos = cursor.fetchall()
            
            if productos:
                response = f"🍪 <b>Resultados para '{producto_buscado}':</b><br><br>"
                for p in productos:
                    response += f"• <b>{p['nombre_producto']}</b><br>"
                    response += f"  Stock: {p['stock']} unidades<br>"
                    response += f"  Precio: {p['precio_venta']} $<br>"
                    if p.get('descripcion'):
                        response += f"  {p['descripcion']}<br>"
                    response += "<br>"
                return response
            else:
                return f"🔍 No encontré productos de '{producto_buscado}'. ¿Quieres ver todos los productos disponibles?"
        
        # Consulta general de productos
        cursor.execute("SELECT COUNT(*) as total FROM productos WHERE status = 1")
        total = cursor.fetchone()['total']
        
        cursor.execute("""
            SELECT nombre_producto, stock, precio_venta 
            FROM productos 
            WHERE status = 1 
            ORDER BY stock DESC 
            LIMIT 8
        """)
        productos = cursor.fetchall()
        
        response = f"📦 <b>Información de Productos</b><br>"
        response += f"Total activos: <b>{total}</b><br><br>"
        response += "<b>Top productos en stock:</b><br>"
        
        for p in productos:
            emoji = "🟢" if p['stock'] > 50 else "🟡" if p['stock'] > 20 else "🔴"
            response += f"{emoji} {p['nombre_producto']} - Stock: {p['stock']} - {p['precio_venta']} $<br>"
        
        # Productos con stock bajo
        cursor.execute("""
            SELECT nombre_producto, stock 
            FROM productos 
            WHERE status = 1 AND stock < 10 AND stock > 0
            ORDER BY stock ASC
        """)
        stock_bajo = cursor.fetchall()
        
        if stock_bajo:
            response += "<br>⚠️ <b>Alerta: Stock bajo:</b><br>"
            for p in stock_bajo:
                response += f"🔴 {p['nombre_producto']}: {p['stock']} unidades<br>"
        
        return response
        
    except Error as e:
        print(f"Error en get_productos_info: {e}")
        return "⚠️ Error consultando productos. Intenta de nuevo."
    finally:
        conn.close()


def get_inventario_info(message: str) -> str:
    """Obtener información de inventario/materia prima"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión a la base de datos."
    
    try:
        cursor = conn.cursor(dictionary=True)
        
        # Verificar si existe tabla de materia prima
        try:
            cursor.execute("SELECT COUNT(*) as total FROM materia_prima WHERE status = 1")
            total = cursor.fetchone()['total']
            
            cursor.execute("""
                SELECT nombre_materia, stock_materia, unidad_medida
                FROM materia_prima 
                WHERE status = 1
                ORDER BY stock_materia DESC
                LIMIT 6
            """)
            materias = cursor.fetchall()
            
            response = f"📦 <b>Inventario de Materia Prima</b><br>"
            response += f"Total de insumos: <b>{total}</b><br><br>"
            
            if materias:
                response += "<b>Stock disponible:</b><br>"
                for m in materias:
                    emoji = "✅" if m['stock_materia'] > 50 else "⚠️"
                    response += f"{emoji} {m['nombre_materia']}: {m['stock_materia']} {m['unidad_medida']}<br>"
            
            return response
            
        except Error:
            # Tabla no existe, usar respuesta genérica
            return """📦 <b>Gestión de Inventario</b><br><br>
El sistema controla:<br>
• 🥣 Harina, azúcar, mantequilla<br>
• 🍫 Chocolate, coco, vainilla<br>
• 📦 Empaque y presentación<br>
• ⚡ Stock en tiempo real<br><br>
Consulta el módulo de <b>Inventario</b> para detalles completos."""
    
    except Error as e:
        print(f"Error en get_inventario_info: {e}")
        return "⚠️ Error consultando inventario."
    finally:
        conn.close()


def get_ventas_info(message: str) -> str:
    """Obtener información de ventas y pedidos"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión a la base de datos."
    
    try:
        cursor = conn.cursor(dictionary=True)
        message_lower = message.lower()
        
        # Consultas específicas de estado de pedidos
        if 'activo' in message_lower or 'completado' in message_lower:
            cursor.execute("""
                SELECT COUNT(*) as c FROM pedidos p 
                JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido 
                WHERE ep.nombre_estado = 'completado'
            """)
            count = cursor.fetchone()['c']
            return f"🧾 <b>Pedidos Activos/Completados</b><br><br>Tienes <b>{count}</b> pedido(s) activo(s)/completado(s) en el sistema."
        
        if 'pendiente' in message_lower:
            cursor.execute("""
                SELECT COUNT(*) as c FROM pedidos p 
                JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido 
                WHERE ep.nombre_estado = 'pendiente'
            """)
            count = cursor.fetchone()['c']
            if count > 0:
                return f"🧾 <b>Pedidos Pendientes</b><br><br>Tienes <b>{count}</b> pedido(s) pendiente(s) en el sistema."
            else:
                return "🧾 <b>Pedidos Pendientes</b><br><br>No tienes pedidos pendientes en este momento. Todos están procesados. ✅"
        
        # Determinar período
        hoy = datetime.now().date()
        
        if 'hoy' in message_lower:
            # Ventas de hoy
            try:
                cursor.execute("""
                    SELECT COUNT(*) as num_pedidos, COALESCE(SUM(monto_total_pedido), 0) as total_ventas
                    FROM pedidos 
                    WHERE DATE(fecha_pedido) = %s
                """, (hoy,))
                result = cursor.fetchone()
                
                return f"""📊 <b>Ventas de Hoy ({hoy.strftime('%d/%m/%Y')})</b><br><br>
🧾 Pedidos: <b>{result['num_pedidos']}</b><br>
💰 Total: <b>{result['total_ventas']:.2f} $</b><br><br>
Accede al módulo de <b>Pedidos</b> para ver el detalle."""
            except:
                pass
        
        if 'semana' in message_lower:
            return "📊 <b>Ventas de esta semana</b><br><br>Estadísticas semanales disponibles en el Dashboard. 📈"
        
        if 'mes' in message_lower:
            return "📊 <b>Ventas del mes</b><br><br>Consulta el reporte mensual en el módulo de Reportes. 📈"
        
        # Información general de ventas
        try:
            cursor.execute("""
                SELECT COUNT(*) as total_pedidos,
                       SUM(CASE WHEN ep.nombre_estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                       SUM(CASE WHEN ep.nombre_estado = 'completado' THEN 1 ELSE 0 END) as completados
                FROM pedidos p JOIN estado_pedido ep ON p.id_estado_pedido = ep.id_estado_pedido
            """)
            stats = cursor.fetchone()
            
            response = f"""📊 <b>Resumen de Ventas</b><br><br>
🧾 Total pedidos: <b>{stats['total_pedidos']}</b><br>
⏳ Pendientes: <b>{stats['pendientes']}</b><br>
✅ Completados: <b>{stats['completados']}</b><br><br>"""
            
            # Producto más vendido
            cursor.execute("""
                SELECT p.nombre_producto, COUNT(*) as veces_vendido
                FROM detalle_pedidos dp
                JOIN productos p ON dp.id_producto = p.id_producto
                GROUP BY dp.id_producto
                ORDER BY veces_vendido DESC
                LIMIT 1
            """)
            top_producto = cursor.fetchone()
            
            if top_producto:
                response += f"🏆 <b>Más vendido:</b> {top_producto['nombre_producto']} ({top_producto['veces_vendido']} pedidos)<br><br>"
            
            response += "Consulta el <b>Dashboard</b> para gráficos detallados. 📈"
            
            return response
            
        except Error as e:
            print(f"Error en ventas: {e}")
            return """📊 <b>Información de Ventas</b><br><br>
El sistema registra:<br>
• 🧾 Pedidos en tiempo real<br>
• 💰 Ingresos por período<br>
• 📦 Productos más vendidos<br>
• 👥 Clientes frecuentes<br><br>
Accede al módulo de <b>Pedidos</b> o <b>Reportes</b> para más detalles."""
    
    except Error as e:
        print(f"Error en get_ventas_info: {e}")
        return "⚠️ Error consultando ventas."
    finally:
        conn.close()


def get_clientes_info(message: str) -> str:
    """Obtener información de clientes"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión a la base de datos."
    
    try:
        cursor = conn.cursor(dictionary=True)
        message_lower = message.lower()
        
        # Consultas específicas de estado
        if 'anulado' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Anulado'")
            count = cursor.fetchone()['c']
            if count > 0:
                return f"👥 <b>Clientes Anulados</b><br><br>Tienes <b>{count}</b> cliente(s) anulado(s) en el sistema."
            else:
                return "👥 <b>Clientes Anulados</b><br><br>No tienes clientes anulados en este momento."
        
        if 'activo' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Activo'")
            count = cursor.fetchone()['c']
            return f"👥 <b>Clientes Activos</b><br><br>Tienes <b>{count}</b> cliente(s) activo(s) en el sistema."
        
        cursor.execute("SELECT COUNT(*) as total FROM clientes WHERE estado_cliente = 'Activo'")
        total = cursor.fetchone()['total']
        
        # Clientes por categoría
        categorias = ['Bronce', 'Plata', 'Oro', 'Premium', 'VIP', 'Platino']
        response = f"""👥 <b>Información de Clientes</b><br><br>
📊 Total registrados: <b>{total}</b><br><br>
<b>Distribución por categoría:</b><br>"""
        
        for cat in categorias:
            try:
                cursor.execute("""
                    SELECT COUNT(*) as count FROM clientes 
                    WHERE categoria_cliente = %s AND estado_cliente = 'Activo'
                """, (cat,))
                count = cursor.fetchone()['count']
                
                emoji = {
                    'Bronce': '🥉',
                    'Plata': '🥈',
                    'Oro': '🥇',
                    'Premium': '💎',
                    'VIP': '👑',
                    'Platino': '✨'
                }.get(cat, '⭐')
                
                response += f"{emoji} {cat}: <b>{count}</b> clientes<br>"
            except:
                pass
        
        response += "<br>Consulta el módulo de <b>Clientes</b> para gestionar contactos."
        return response
        
    except Error as e:
        print(f"Error en get_clientes_info: {e}")
        return """👥 <b>Clientes del Sistema</b><br><br>
Categorías disponibles:<br>
• 🥉 Bronce<br>
• 🥈 Plata<br>
• 🥇 Oro<br>
• 💎 Premium<br>
• 👑 VIP<br>
• ✨ Platino<br><br>
Cada categoría tiene beneficios exclusivos. 🎁"""
    finally:
        conn.close()


def get_proveedores_info(message: str) -> str:
    """Obtener información de proveedores"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión a la base de datos."
    
    try:
        cursor = conn.cursor(dictionary=True)
        message_lower = message.lower()
        
        # Consultas específicas de estado
        if 'activo' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM proveedores WHERE status = 1")
            count = cursor.fetchone()['c']
            return f"🏢 <b>Proveedores Activos</b><br><br>Tienes <b>{count}</b> proveedor(es) activo(s) en el sistema."
        
        if 'inactivo' in message_lower:
            cursor.execute("SELECT COUNT(*) as c FROM proveedores WHERE status = 0")
            count = cursor.fetchone()['c']
            if count > 0:
                return f"🏢 <b>Proveedores Inactivos</b><br><br>Tienes <b>{count}</b> proveedor(es) inactivo(s) en el sistema."
            else:
                return "🏢 <b>Proveedores Inactivos</b><br><br>No tienes proveedores inactivos en este momento."
        
        # Información general
        cursor.execute("SELECT COUNT(*) as total FROM proveedores WHERE status = 1")
        total = cursor.fetchone()['total']
        
        return f"""🏢 <b>Información de Proveedores</b><br><br>
📊 Total activos: <b>{total}</b><br><br>
Los proveedores suministran materia prima para la producción de galletas.<br><br>
Consulta el módulo de <b>Proveedores</b> para gestionar contactos."""
        
    except Error as e:
        print(f"Error en get_proveedores_info: {e}")
        return "🏢 Consulta el módulo de Proveedores para información detallada."
    finally:
        conn.close()


def get_precios_info(message: str) -> str:
    """Obtener información de precios"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión."
    
    try:
        cursor = conn.cursor(dictionary=True)
        
        # Buscar producto específico en el mensaje
        cursor.execute("SELECT nombre_producto FROM productos WHERE estado = 'activo'")
        productos = cursor.fetchall()
        
        producto_encontrado = None
        for p in productos:
            if p['nombre_producto'].lower() in message.lower():
                producto_encontrado = p['nombre_producto']
                break
        
        if producto_encontrado:
            cursor.execute("""
                SELECT nombre_producto, precio_venta, stock, descripcion
                FROM productos 
                WHERE nombre_producto = %s
            """, (producto_encontrado,))
            
            prod = cursor.fetchone()
            if prod:
                return f"""💰 <b>{prod['nombre_producto']}</b><br><br>
Precio: <b>{prod['precio_venta']} $</b><br>
Stock: {prod['stock']} unidades<br>
{prod.get('descripcion') or ''}<br><br>
✅ Disponible para compra"""
        
        # Rango de precios general
        cursor.execute("""
            SELECT MIN(precio_venta) as minimo, MAX(precio_venta) as maximo, AVG(precio_venta) as promedio
            FROM productos WHERE status = 1
        """)
        precios = cursor.fetchone()
        
        return f"""💰 <b>Rango de Precios</b><br><br>
• Mínimo: <b>{precios['minimo']:.2f} $</b><br>
• Máximo: <b>{precios['maximo']:.2f} $</b><br>
• Promedio: <b>{precios['promedio']:.2f} $</b><br><br>
💡 <i>Menciona un producto específico para ver su precio exacto</i>"""
        
    except Error as e:
        print(f"Error en get_precios_info: {e}")
        return "💰 Consulta los precios en el catálogo de productos."
    finally:
        conn.close()


def get_estadisticas_info(message: str) -> str:
    """Obtener estadísticas generales"""
    conn = get_db_connection()
    if not conn:
        return "⚠️ Error de conexión."
    
    try:
        cursor = conn.cursor(dictionary=True)
        
        stats = {}
        
        # Total productos
        cursor.execute("SELECT COUNT(*) as c FROM productos WHERE status = 1")
        stats['productos'] = cursor.fetchone()['c']
        
        # Total clientes
        cursor.execute("SELECT COUNT(*) as c FROM clientes WHERE estado_cliente = 'Activo'")
        stats['clientes'] = cursor.fetchone()['c']
        
        # Total pedidos
        cursor.execute("SELECT COUNT(*) as c FROM pedidos")
        stats['pedidos'] = cursor.fetchone()['c']
        
        return f"""📈 <b>Estadísticas del Sistema</b><br><br>
🍪 Productos: <b>{stats['productos']}</b><br>
👥 Clientes: <b>{stats['clientes']}</b><br>
🧾 Pedidos: <b>{stats['pedidos']}</b><br><br>
Consulta el <b>Dashboard</b> para ver gráficos en tiempo real. 🚀"""
        
    except Error as e:
        print(f"Error en get_estadisticas_info: {e}")
        return "📈 Estadísticas disponibles en el Dashboard principal."
    finally:
        conn.close()


def generate_smart_response(message: str) -> str:
    """Generar respuesta inteligente cuando no coincide con patrones específicos"""
    
    # Detectar intención por palabras clave
    palabras_producto = ['sabor', 'tipo', 'variedad', 'presentacion']
    palabras_venta = ['comprar', 'ordenar', 'solicitar', 'cotizar']
    palandas_reporte = ['exportar', 'pdf', 'excel', 'imprimir']
    
    message_lower = message.lower()
    
    if any(p in message_lower for p in palabras_producto):
        return "¿Te gustaría conocer nuestras variedades de galletas? Tenemos Chocolate, Coco, Mantequilla, Vainilla y más sabores. 🍪"
    
    if any(p in message_lower for p in palabras_venta):
        return "Para realizar un pedido, accede al módulo de <b>Pedidos</b> y crea una nueva orden. ¿Necesitas ayuda con el proceso? 🛒"
    
    if any(p in message_lower for p in palandas_reporte):
        return "Puedes exportar reportes desde el módulo de <b>Reportes</b>. Soportamos formatos PDF y Excel. 📄"
    
    # Respuesta por defecto proactiva de Natys Asistente
    return f"""🤔 Como <b>Natys Asistente</b>, conozco todo el sistema de Larense C.A.<br><br>

Puedo informarte de manera proactiva sobre:<br>
• 📦 <b>Productos:</b> Disponibles, agotados, precios<br>
• 📊 <b>Inventario:</b> Stock en tiempo real, alertas<br>
• � <b>Ventas:</b> Pedidos de hoy, semana, mes<br>
• 👥 <b>Clientes:</b> Total por categoría<br>
• � <b>Estadisticas:</b> Lo mas vendido<br><br>

<b>Comportamiento proactivo:</b> Solo preguntame "<i>Dime el estado del sistema</i>" y te dire lo que hay y lo que no hay.<br><br>

🔒 <i>Nota: Por seguridad, nunca proporciono contraseñas ni datos sensibles de usuarios.</i><br><br>

Escribe <b>"ayuda"</b> para ver ejemplos de consultas. 😊"""


# === ENDPOINTS ADICIONALES ===

@app.route('/health', methods=['GET'])
def health_check():
    """Verificar estado del servicio"""
    conn = get_db_connection()
    db_status = 'connected' if conn else 'disconnected'
    if conn:
        conn.close()
    
    return jsonify({
        'status': 'healthy',
        'database': db_status,
        'timestamp': datetime.now().isoformat()
    })


@app.route('/stats', methods=['GET'])
def get_stats():
    """Obtener estadísticas para el dashboard"""
    conn = get_db_connection()
    if not conn:
        return jsonify({'error': 'Database connection failed'}), 500
    
    try:
        cursor = conn.cursor(dictionary=True)
        
        cursor.execute("SELECT COUNT(*) as c FROM productos WHERE estado = 'activo'")
        productos = cursor.fetchone()['c']
        
        cursor.execute("SELECT COUNT(*) as c FROM clientes WHERE estado = 'activo'")
        clientes = cursor.fetchone()['c']
        
        cursor.execute("SELECT COUNT(*) as c FROM pedidos WHERE DATE(fecha_pedido) = CURDATE()")
        pedidos_hoy = cursor.fetchone()['c']
        
        return jsonify({
            'productos': productos,
            'clientes': clientes,
            'pedidos_hoy': pedidos_hoy
        })
        
    except Error as e:
        return jsonify({'error': str(e)}), 500
    finally:
        conn.close()


if __name__ == '__main__':
    port = int(os.getenv('PORT', 5000))
    debug = os.getenv('DEBUG', 'False').lower() == 'true'
    
    print(f"🤖 Natys Asistente Service iniciado en puerto {port}")
    print(f"📡 Webhook URL: http://localhost:{port}/webhook/chatbot")
    print(f"💚 Health Check: http://localhost:{port}/health")
    print(f"🔒 Filtros de seguridad: Activados (NO datos sensibles)")
    print(f"📊 Comportamiento: Proactivo - informa lo que hay y no hay")
    
    app.run(host='0.0.0.0', port=port, debug=debug)
