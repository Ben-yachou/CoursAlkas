<?php
require_once('user.php');

class BlogArticle
{
    public int $id;
    public BlogUser $author;
    public string $title;
    public string $content;
    public DateTime $created_at;

    public function __construct(int $id, BlogUser $author, string $title, string $content, DateTime $created_at)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }
}
