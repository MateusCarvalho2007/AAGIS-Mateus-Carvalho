import smtplib
from email.message import EmailMessage

def enviar_email_simples():
    """Versão ultra-simplificada"""
    
    # Configuração
    meu_email = "svaagisifrs@gmail.com" 
    minha_senha = "lxff suay qplv ecaf"
    
    # Destinatário
    para_nome = "Mateus"
    para_email = "vojoja125@gmail.com"
    assunto =  "teste envio de emails"
    mensagem  = "Bom dia!"
    
    # Enviar
    try:
        with smtplib.SMTP('smtp.gmail.com', 587) as smtp:
            smtp.starttls()
            smtp.login(meu_email, minha_senha)
            
            msg = EmailMessage()
            msg['Subject'] = assunto
            msg['From'] = meu_email
            msg['To'] = para_email
            msg.set_content(f"Olá {para_nome}!\n\n{mensagem}")
            
            smtp.send_message(msg)
            print("Email enviado com sucesso!")
            
    except Exception as e:
        print(f"Erro: {e}")

# Execute:
enviar_email_simples()