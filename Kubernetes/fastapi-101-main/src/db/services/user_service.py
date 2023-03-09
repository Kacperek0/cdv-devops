import sqlalchemy.orm as orm

import db.database as db
from db.models import (
    post as post_model,
    user as user_model
)
from db.schemas import (
    post_schema as post_schema,
    user_schema as user_schema
)

import fastapi as _fastapi


def get_user_by_email(email: str, db: orm.Session):
    return db.query(user_model.User).filter(user_model.User.email == email).first()


def create_user(user: user_schema.User, db: orm.Session):
    fake_hashed_password = user.password + 'notreallyhashed'
    db_user = user_model.User(email=user.email, hashed_password=fake_hashed_password)
    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user


def get_users(
    skip: int = 0,
    limit: int = 100,
    db: orm.Session = db.SessionLocal()
):
    return db.query(user_model.User).offset(skip).limit(limit).all()


def get_user(
    user_id: int,
    db: orm.Session = db.SessionLocal()
):
    return db.query(user_model.User).filter(user_model.User.id == user_id).first()


def create_post_for_user(
    user_id: int,
    post: post_schema.PostCreate,
    db: orm.Session = db.SessionLocal()
):
    post = post_model.Post(**post_model.dict(), owner_id=user_id)
    db.add(post)
    db.commit()
    db.refresh(post)
    return post
