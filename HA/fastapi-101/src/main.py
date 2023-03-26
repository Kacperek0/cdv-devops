from db.services import (
    create_database,
    database_session,
    user_service as user_service,
    post_service as post_service
)

from db.schemas import (
    post_schema as post_schema,
    user_schema as user_schema
)

import fastapi as _fastapi
import sqlalchemy.orm as _orm

app = _fastapi.FastAPI()

create_database.create_database()

@app.post('/users', response_model=user_schema.User, tags=['users'])
def create_user(
    user: user_schema.UserCreate,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    db_user = user_service.get_user_by_email(user.email, db)
    if db_user:
        raise _fastapi.HTTPException(status_code=400, detail='Email already registered')

    return user_service.create_user(user, db)


@app.get('/users', response_model=list[user_schema.User], tags=['users'])
def get_users(
    skip: int = 0,
    limit: int = 100,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    users = user_service.get_users(skip=skip, limit=limit, db=db)
    return users


@app.get('/user/{user_id}', response_model=user_schema.User, tags=['users'])
def get_user(
    user_id: int,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    db_user = user_service.get_user(user_id, db)
    if db_user is None:
        raise _fastapi.HTTPException(status_code=404, detail='User not found')

    return db_user


@app.get('/posts', response_model=list[post_schema.Post], tags=['posts'])
def get_posts(
    skip: int = 0,
    limit: int = 100,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    posts = post_service.get_posts(skip=skip, limit=limit, db=db)
    return posts


@app.get('/posts/{post_id}', response_model=post_schema.Post, tags=['posts'])
def get_post(
    post_id: int,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    post = post_service.get_post(post_id, db)
    if post is None:
        raise _fastapi.HTTPException(status_code=404, detail='Post not found')

    return post


@app.put('/posts/{post_id}', response_model=post_schema.Post, tags=['posts'])
def update_post(
    post_id: int,
    post: post_schema.PostCreate,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    post = post_service.update_post(post_id, post, db)
    if post is None:
        raise _fastapi.HTTPException(status_code=404, detail='Post not found')

    return post


@app.post('/users/{user_id}/posts', response_model=post_schema.Post, tags=['posts'])
def create_post_for_user(
    user_id: int,
    post: post_schema.PostCreate,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    db_user = user_service.get_user(user_id, db)
    if db_user is None:
        raise _fastapi.HTTPException(status_code=404, detail='User not found')

    return user_service.create_post_for_user(user_id, post, db)


@app.delete('/posts/{post_id}', response_model=post_schema.Post, tags=['posts'])
def delete_post(
    post_id: int,
    db: _orm.Session = _fastapi.Depends(database_session.database_session)
):
    post = post_service.delete_post(post_id, db)
    if post is None:
        raise _fastapi.HTTPException(status_code=404, detail='Post not found')

    return post


@app.get('/')
def get_main():
    return { 200: 'OK' }


if __name__ == "__main__":
    import uvicorn
    uvicorn.run('main:app', host='0.0.0.0', port=80, reload=True)
