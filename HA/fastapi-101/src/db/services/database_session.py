import db.database as db


def database_session():
    db_session = db.SessionLocal()
    try:
        yield db_session
    finally:
        db_session.close()
