<?php

class BlogImage
{
    public int $id;
    public string $name;
    public string $path;
    public DateTime $created_at;
    public BlogArticle $article;

    public function __construct(int $id, string $name, string $path, DateTime $created_at, BlogArticle $article)
    {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->created_at = $created_at;
        $this->article = $article;
    }

    public function __toString()
    {
        return $this->path;
    }
}
