import sqlalchemy.orm as orm

from db.services.database_session import database_session

import db.database as db
from db.models import post as post_model
from db.schemas import post_schema as post_schema

import fastapi as _fastapi


def get_posts(
    skip: int = 0,
    limit: int = 100,
    db: orm.Session = db.SessionLocal()
):
    return db.query(post_model.Post).offset(skip).limit(limit).all()


def get_post(
    post_id: int,
    db: orm.Session = db.SessionLocal()
):
    return db.query(post_model.Post).filter(post_model.Post.id == post_id).first()


def update_post(
    post_id: int,
    post: post_schema.PostCreate,
    db: orm.Session = db.SessionLocal()
):
    db_post = db.query(post_model.Post).filter(post_model.Post.id == post_id).first()
    if db_post is None:
        raise _fastapi.HTTPException(status_code=404, detail='Post not found')
    db_post.title = post.title
    db_post.body = post.body
    db.commit()
    db.refresh(db_post)
    return db_post


def delete_post(
    post_id: int,
    db: orm.Session = db.SessionLocal()
):
    db_post = db.query(post_model.Post).filter(post_model.Post.id == post_id).first()
    if db_post is None:
        raise _fastapi.HTTPException(status_code=404, detail='Post not found')
    db.delete(db_post)
    db.commit()
    return db_post
