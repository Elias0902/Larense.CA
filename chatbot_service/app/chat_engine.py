# app/chat_engine.py
import json
import inspect
from typing import List, Dict, Any, Optional
from google import genai
from google.genai import types
from app.config import settings
from app.tools import TOOLS_DEFINITION, TOOL_MAP

class ChatEngine:
    def __init__(self):
        self.client = genai.Client(api_key=settings.GEMINI_API_KEY)
        self.model = settings.GEMINI_MODEL

    async def process_message(
        self,
        user_message: str,
        user_id: int,
        session_id: Optional[str] = None,
        conversation_history: List[Dict[str, Any]] = None
    ) -> str:
        if conversation_history is None:
            conversation_history = []

        # Construir contenido para Gemini
        contents = []
        for msg in conversation_history:
            role = "user" if msg["role"] == ["user"] else "model"
            contents.append(types.Content(
                role=role,
                parts=[types.Part(text=msg["content"])]
            ))
        contents.append(types.Content(
            role="user",
            parts=[types.Part(text=user_message)]
        ))

        tools = [types.Tool(function_declarations=TOOLS_DEFINITION)]

        # System prompt detallado con esquema de BD y reglas
        system_instruction = (
            "Eres un asistente virtual especializado en el sistema de gestión 'Larence'. "
            "Tu única herramienta para acceder a datos es `ejecutar_sql`, que ejecuta consultas SELECT. "
            "Debes generar la consulta SQL apropiada según la pregunta del usuario, usando el esquema de la base de datos que se te proporciona. "
            "Responde siempre en español, de forma clara, amigable y profesional. Formatea los resultados de forma legible (tablas, viñetas, emojis).\n\n"
            
            "### ESQUEMA COMPLETO DE LA BASE DE DATOS (tablas y columnas más relevantes):\n"
            "- **categorias**: id_categoria (INT), nombre_categoria (VARCHAR), status (INT, 1=activo)\n"
            "- **clientes**: id_cliente (INT), tipo_id (VARCHAR), id_tipo_cliente (INT, FK a tipos_clientes), nombre_cliente (VARCHAR), direccion_cliente (VARCHAR), tlf_cliente (VARCHAR), email_cliente (VARCHAR), estado_cliente (VARCHAR: Activo/Anulado/Pendiente), status (INT)\n"
            "- **tipos_clientes**: id_tipo_cliente (INT), nombre_tipo_cliente (VARCHAR), dias_credito (INT)\n"
            "- **productos**: id_producto (INT), nombre_producto (VARCHAR), precio_venta (FLOAT), stock (INT), fecha_registro (DATE), fecha_vencimiento (DATE), id_categoria (INT, FK a categorias), status (INT)\n"
            "- **pedidos**: id_pedido (INT), id_cliente (INT, FK a clientes), fecha_pedido (DATETIME), fecha_entrega (DATETIME), id_estado_pedido (INT), id_estado_pago (INT), monto_total_pedido (FLOAT), fecha_vencimieno_pedido (DATETIME), status (INT)\n"
            "- **detalle_pedidos**: id_detalle_pedido (INT), id_pedido (INT, FK a pedidos), id_producto (INT, FK a productos), cantidad (INT), precio_unitario (FLOAT)\n"
            "- **promociones**: id_promocion (INT), nombre_promocion (VARCHAR), descripcion_promocion (VARCHAR), fecha_inicio (DATE), fecha_fin (DATE), tipo_descuento (VARCHAR: 'porcentaje', '2x1', etc.), valor_descuento (FLOAT), estado (INT), status (INT)\n"
            "- **detalle_promocion**: id_detalle_promocion (INT), id_promocion (INT), id_producto (INT)\n"
            "- **producciones**: id_produccion (INT), id_producto (INT), cantidad_producida (INT), fecha_produccion (DATE), motivo_produccion (VARCHAR), observacion (VARCHAR), status (INT)\n"
            "- **detalle_producciones**: id_detalle_produccion (INT), id_produccion (INT), id_materia_prima (INT), cantidad_utilizada (INT)\n"
            "- **materia_prima**: id_materia_prima (INT), nombre_materia_prima (VARCHAR), stock_actual (INT), id_proveedor (INT), id_unidad_medida (INT)\n"
            "- **proveedores**: id_proveedor (INT), nombre_proveedor (VARCHAR), direccion_proveedor (VARCHAR), tlf_proveedor (VARCHAR), email_proveedor (VARCHAR), status (INT)\n"
            "- **unidad_medidas**: id_unidad_medida (INT), nombre_medida (VARCHAR)\n"
            "- **compras**: id_compras (INT), id_proveedor (INT), fecha_compra (DATETIME), monto_total_compra (FLOAT), status (INT)\n"
            "- **tasa_dia**: id_tasa (INT), monto_tasa (FLOAT), fecha_tasa (DATETIME), status (INT)\n"
            "- Otras tablas: cuenta_x_cobrar, cuenta_x_pagar, pagos, pagos_proveedores, entregas, estado_entrega, estado_pago, estado_pedido, metodos_pago (puedes consultar su estructura con SELECT si es necesario).\n\n"
            
            "### CAPACIDADES QUE DEBES CUBRIR CON SQL:\n"
            "- **Consultas simples**: listar categorías, productos, clientes, proveedores, etc.\n"
            "- **Análisis de patrones de compra**: productos más comprados por cliente, frecuencia de pedidos, monto promedio, estacionalidad.\n"
            "- **Predicción de pedidos**: basada en el historial de fechas de pedido y frecuencia (ej. calcular promedio de días entre pedidos, y predecir próxima fecha).\n"
            "- **Sugerencia de promociones**: buscar promociones activas que se apliquen a productos que el cliente suele comprar.\n"
            "- **Productos más vendidos** en un período.\n"
            "- **Clientes con mayor potencial** (mayor gasto total, frecuencia, etc.).\n"
            "- **Stock y producción**: alertar si stock bajo, sugerir producción según demanda.\n\n"
            
            "### REGLAS IMPORTANTES:\n"
            "- **Solo usa `ejecutar_sql`**. No inventes otras herramientas.\n"
            "- Si la pregunta implica análisis o predicción, genera una o varias consultas SQL que extraigan los datos necesarios, luego procesa los resultados y da una respuesta interpretada.\n"
            "- Limita los resultados a 20 filas a menos que el usuario pida más.\n"
            "- Para predicciones (ej. '¿cuándo volverá a pedir el cliente X?'), puedes calcular el promedio de días entre sus pedidos anteriores y sumarlo a la última fecha.\n"
            "- Para sugerir promociones, busca en `promociones` donde fecha_inicio <= hoy <= fecha_fin y estado=1, y relaciona con productos que el cliente haya comprado.\n"
            "- Siempre muestra los datos de forma legible: usa viñetas, emojis (📦, 💰, 🛒, 📅, etc.) y tablas simples.\n"
            "- Si una consulta SQL falla, explica el error amigablemente.\n"
            "- Nunca permitas INSERT, UPDATE, DELETE, DROP, ALTER, etc.\n"
            "- Cuando muestres números con decimales, redondea a 2 decimales.\n"
            "- Para consultar créditos de un cliente, usa la tabla `cuenta_x_cobrar` (saldo_pendiente) y relaciónala con `pedidos` y `clientes`.\n\n"
            
            "### EJEMPLOS DE CONSULTAS QUE PUEDES GENERAR:\n"
            "- **Patrones de compra del cliente 310398110**:\n"
            "  ```sql\n"
            "  SELECT p.nombre_producto, SUM(dp.cantidad) as total_comprado, AVG(dp.precio_unitario) as precio_promedio\n"
            "  FROM detalle_pedidos dp\n"
            "  JOIN pedidos pe ON dp.id_pedido = pe.id_pedido\n"
            "  JOIN productos p ON dp.id_producto = p.id_producto\n"
            "  WHERE pe.id_cliente = 310398110\n"
            "  GROUP BY p.id_producto\n"
            "  ORDER BY total_comprado DESC\n"
            "  LIMIT 5;\n"
            "  ```\n"
            "- **Predecir próxima fecha de pedido para cliente 32200771**:\n"
            "  ```sql\n"
            "  SELECT DATEDIFF(MAX(fecha_pedido), MIN(fecha_pedido)) / (COUNT(*) - 1) as intervalo_promedio_dias,\n"
            "         MAX(fecha_pedido) as ultima_fecha\n"
            "  FROM pedidos WHERE id_cliente = 32200771 AND status = 1;\n"
            "  ```\n"
            "- **Sugerir promociones para un cliente**:\n"
            "  ```sql\n"
            "  SELECT pr.*, p.nombre_producto\n"
            "  FROM promociones pr\n"
            "  JOIN detalle_promocion dp ON pr.id_promocion = dp.id_promocion\n"
            "  JOIN productos p ON dp.id_producto = p.id_producto\n"
            "  WHERE pr.fecha_inicio <= CURDATE() AND pr.fecha_fin >= CURDATE()\n"
            "    AND pr.estado = 1 AND p.id_producto IN (SELECT DISTINCT id_producto FROM detalle_pedidos WHERE id_pedido IN (SELECT id_pedido FROM pedidos WHERE id_cliente = 32200771));\n"
            "  ```\n\n"
            
            "Sé proactivo y creativo al generar SQL. Si el usuario pide un análisis que requiera múltiples pasos, puedes hacer varias llamadas a `ejecutar_sql` (el sistema lo permite). Siempre prioriza la claridad y la utilidad de la respuesta."
        )

        # Primera llamada
        response = self.client.models.generate_content(
            model=self.model,
            contents=contents,
            config=types.GenerateContentConfig(
                tools=tools,
                system_instruction=system_instruction,
                temperature=0.7,
            )
        )

        # Procesar respuesta
        if not response.candidates or not response.candidates[0].content:
            return "No pude procesar tu solicitud."

        parts = response.candidates[0].content.parts

        # Buscar function_call
        function_call_part = None
        for part in parts:
            if part.function_call:
                function_call_part = part
                break

        if not function_call_part:
            # Respuesta directa en texto
            for part in parts:
                if part.text:
                    return part.text
            return "Respuesta no válida."

        # --- Ejecutar la herramienta ---
        func_name = function_call_part.function_call.name
        func_args = function_call_part.function_call.args or {}
        func = TOOL_MAP.get(func_name)

        if not func:
            result_text = f"Error: herramienta '{func_name}' no implementada."
        else:
            # Inyectar user_id si la función lo requiere (por nombre de parámetro)
            if "user_id" in inspect.signature(func).parameters:
                func_args["user_id"] = user_id

            # Ejecutar función (async o sync)
            if inspect.iscoroutinefunction(func):
                result = await func(**func_args)
            else:
                result = func(**func_args)
            
            # Convertir resultado a texto
            if isinstance(result, (dict, list)):
                result_text = json.dumps(result, ensure_ascii=False)
            else:
                result_text = str(result)

        # Construir el mensaje de respuesta de la función
        function_response_part = types.Part(
            function_response=types.FunctionResponse(
                name=func_name,
                response={"result": result_text}
            )
        )

        # Agregar al historial: primero el mensaje del modelo con function_call,
        # luego nuestro mensaje con function_response
        contents.append(types.Content(
            role="model",
            parts=[function_call_part]
        ))
        contents.append(types.Content(
            role="user",
            parts=[function_response_part]
        ))

        # Segunda llamada a Gemini
        final_response = self.client.models.generate_content(
            model=self.model,
            contents=contents,
            config=types.GenerateContentConfig(
                tools=tools,
                system_instruction=system_instruction,
                temperature=0.7,
            )
        )

        # Extraer texto final
        if final_response.candidates and final_response.candidates[0].content:
            for part in final_response.candidates[0].content.parts:
                if part.text:
                    return part.text

        return "Lo siento, no pude generar una respuesta."

chat_engine = ChatEngine()