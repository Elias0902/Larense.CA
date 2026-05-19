from fastapi import APIRouter, HTTPException, Depends
from fastapi.security import APIKeyHeader
from app.models import ChatRequest, ChatResponse
from app.chat_engine import chat_engine
from app.config import settings
import uuid
from datetime import datetime

router = APIRouter()
api_key_header = APIKeyHeader(name="X-API-Key", auto_error=False)

session_metadata = {}

async def verify_api_key(api_key: str = Depends(api_key_header)):
    if api_key != settings.CHATBOT_API_KEY:
        raise HTTPException(status_code=403, detail="API Key inválida")
    return api_key

@router.post("/chat", response_model=ChatResponse)
async def chat_endpoint(
    request: ChatRequest,
    authenticated: str = Depends(verify_api_key)
):
    session_id = request.session_id
    if not session_id:
        session_id = str(uuid.uuid4())
        session_metadata[session_id] = {"created_at": datetime.now()}
    
    answer = await chat_engine.process_message(
        user_message=request.message,
        user_id=request.user_id,
        session_id=session_id
    )
    return ChatResponse(response=answer, session_id=session_id)

@router.get("/health")
async def health_check():
    return {"status": "ok", "service": "chatbot"}