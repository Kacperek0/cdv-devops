import sqlalchemy as sql
import sqlalchemy.orm as orm

from db.database import Base

class User(Base):
    __tablename__ = "users"

    id = sql.Column(sql.Integer, primary_key=True, index=True)
    email = sql.Column(sql.String, unique=True, index=True)
    hashed_password = sql.Column(sql.String)
    is_active = sql.Column(sql.Boolean, default=True)

    posts = orm.relationship("Post", back_populates="owner")
