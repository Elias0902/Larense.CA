#app/main.py

# se importa las dependencias
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from app.routes import router
from app.config import settings

# se crea la aplicacion FastApi
app = FastAPI(title=settings.APP_NAME, debug=settings.DEBUG)

# Configurar CORS (permitir solicitudes desde el frontend PHP y otros orígenes)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# se incluye rutas
app.include_router(router, prefix="/api/v1")

# Para ejecutar directamente con uvicorn
if __name__ == "__main__":
    import uvicorn
    uvicorn.run(
        "app.main:app",
        host=settings.APP_HOST,
        port=settings.APP_PORT,
        reload=settings.DEBUG
    )