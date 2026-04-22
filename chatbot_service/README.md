# Natys Asistente Service

Asistente virtual inteligente y proactivo para Larense C.A - Sistema de gestión de galletas.

## ✨ Características Principales

- **🧠 Conocimiento Total:** Conoce TODO el sistema (productos, ventas, clientes, inventario)
- **� Comportamiento Proactivo:** Informa lo que hay y lo que no hay sin necesidad de búsqueda manual
- **🔒 Seguridad Integrada:** NUNCA revela contraseñas, datos sensibles o información privada de usuarios
- **💬 Lenguaje Respetuoso:** Siempre profesional, sin groserías ni lenguaje inapropiado

## �📁 Estructura

```
chatbot_service/
├── app.py                 # Servicio Flask principal
├── requirements.txt       # Dependencias Python
├── .env.example          # Ejemplo de configuración
├── n8n_workflow.json     # Workflow para n8n
└── README.md             # Este archivo
```

## 🚀 Instalación

### 1. Instalar dependencias

```bash
cd chatbot_service
pip install -r requirements.txt
```

### 2. Configurar variables de entorno

```bash
copy .env.example .env
# Editar .env con tus credenciales de base de datos
```

### 3. Iniciar el servicio

```bash
python app.py
```

El servicio se iniciará en `http://localhost:5000`

## 🔌 Endpoints

| Endpoint | Método | Descripción |
|----------|--------|-------------|
| `/webhook/chatbot` | POST | Webhook principal para n8n |
| `/api/query` | POST | Endpoint directo (sin n8n) |
| `/health` | GET | Verificar estado del servicio |
| `/stats` | GET | Estadísticas del sistema |

## 🤖 n8n Integration

### Opción 1: Usar n8n (Recomendado)

1. Importa el workflow `n8n_workflow.json` en tu instancia de n8n
2. Configura el webhook URL en `api/chatbot.php`:
   ```php
   $use_n8n = true;
   $n8n_webhook_url = 'http://localhost:5678/webhook/chatbot-larence';
   ```

### Opción 2: Sin n8n (Modo directo)

En `api/chatbot.php`:
```php
$use_n8n = false;  // Usa procesamiento local PHP
```

O conecta directamente al servicio Python cambiando la URL en el JavaScript del chatbot.

## 💬 Capacidades de Natys Asistente

Natys puede responder consultas de manera proactiva sobre:

- 📦 **Productos**: Stock, disponibilidad, descripciones
- 📊 **Ventas**: Pedidos, estadísticas, ingresos
- 👥 **Clientes**: Total por categoría, información general
- 💰 **Precios**: Consultas de precios específicos
- 📈 **Estadísticas**: Resúmenes del sistema

## 🎨 Personalización

### Cambiar colores
Edita el archivo `components/chatbot.php` y modifica las variables CSS:
```css
.chatbot-toggle {
    background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
}
```

### Agregar nuevas consultas
Edita `app.py` y agrega nuevas funciones en `process_query()`.

### Comportamiento Proactivo
Natys puede dar un resumen completo del sistema con la consulta:
- "Dime el estado del sistema"
- "Resumen general"
- "¿Qué tal el sistema?"

Esto mostrará:
- Total de productos (disponibles y agotados)
- Clientes registrados
- Ventas de hoy
- Alertas de stock bajo
- Productos agotados

## 🔧 Troubleshooting

### Error de conexión a MySQL
- Verifica que las credenciales en `.env` sean correctas
- Asegúrate de que MySQL esté corriendo en XAMPP
- Verifica que las tablas existan

### n8n no responde
- Verifica que n8n esté corriendo en el puerto 5678
- Comprueba que el webhook esté activo en la interfaz de n8n
- Revisa los logs de n8n

### El chatbot no aparece
- Verifica que `components/chatbot.php` esté incluido en `header.php`
- Revisa la consola del navegador por errores JavaScript

## 📞 Soporte

Para soporte técnico o dudas sobre el chatbot, contacta al equipo de desarrollo de Larense C.A.

---

**Natys Asistente v1.0** - Hecho con ❤️ para Larense C.A

*"Informando lo que hay y lo que no hay, siempre con seguridad y profesionalismo"*
