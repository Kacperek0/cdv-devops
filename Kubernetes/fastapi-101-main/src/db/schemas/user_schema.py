from datetime import datetime

from pydantic import BaseModel

from .post_schema import Post


class _UserBase(BaseModel):
    email: str


class UserCreate(_UserBase):
    password: str


class User(_UserBase):
    id: int
    is_active: bool
    posts: list[Post] = []

    class Config:
        orm_mode = True
