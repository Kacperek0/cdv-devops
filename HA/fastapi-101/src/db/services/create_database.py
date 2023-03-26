import db.database as db


def create_database():
    return db.Base.metadata.create_all(bind=db.engine)
