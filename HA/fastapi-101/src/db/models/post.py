import datetime as dt

import sqlalchemy as sql
import sqlalchemy.orm as orm

from db.database import Base

class Post(Base):
    __tablename__ = "posts"

    id = sql.Column(sql.Integer, primary_key=True, index=True)
    title = sql.Column(sql.String, index=True)
    body = sql.Column(sql.String, index=True)
    owner_id = sql.Column(sql.Integer, sql.ForeignKey("users.id"))
    date_created = sql.Column(sql.DateTime, default=sql.func.now())
    date_updated = sql.Column(sql.DateTime, default=sql.func.now(), onupdate=sql.func.now())

    owner = orm.relationship("User", back_populates="posts")
