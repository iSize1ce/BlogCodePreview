<?php declare(strict_types=1);

namespace Post;

class PostSearchTerm
{
    public const TYPE_EQUALS = 'equals';
    public const TYPE_LIKE = 'like';

    private string $type;
    private ?string $value;

    public function __construct(string $type, ?string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function isTypeEquals(): bool
    {
        return $this->type === self::TYPE_EQUALS;
    }

    public function isTypeLike(): bool
    {
        return $this->type === self::TYPE_LIKE;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
