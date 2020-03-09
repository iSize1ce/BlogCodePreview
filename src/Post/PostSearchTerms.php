<?php declare(strict_types=1);

namespace Post;

class PostSearchTerms
{
    private PostSearchTerm $title;
    private PostSearchTerm $content;

    public function __construct(?PostSearchTerm $title, ?PostSearchTerm $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function getTitle(): ?PostSearchTerm
    {
        return $this->title;
    }

    public function getContent(): ?PostSearchTerm
    {
        return $this->content;
    }
}
