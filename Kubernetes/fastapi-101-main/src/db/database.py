import os

import sqlalchemy as sql
import sqlalchemy.ext.declarative as declarative
import sqlalchemy.orm as orm

from dotenv import load_dotenv

load_dotenv()


SQLALCHEMY_DATABASE_URL = f"sqlite:///./database.db"

engine = sql.create_engine(
    SQLALCHEMY_DATABASE_URL
)

SessionLocal = orm.sessionmaker(autocommit=False, autoflush=False, bind=engine)

Base = declarative.declarative_base()
