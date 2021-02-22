<?php

class BlogComment
{
    public int $id;
    public string $content;
    public DateTime $created_at;
    public BlogUser $author;
    public BlogArticle $article;

    public function __construct(int $id, string $content, DateTime $created_at, BlogUser $author, BlogArticle $article)
    {
        $this->id = $id;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->author = $author;
        $this->article = $article;
    }
}
