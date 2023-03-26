from datetime import datetime

from pydantic import BaseModel


class _PostBase(BaseModel):
    title: str
    body: str


class PostCreate(_PostBase):
    pass


class Post(_PostBase):
    id: int
    owner_id: int
    date_created: datetime
    date_updated: datetime

    class Config:
        orm_mode = True
