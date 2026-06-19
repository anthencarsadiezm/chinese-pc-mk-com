<?php
/**
 * Site meta information container with description generation.
 *
 * This file provides a structured way to store site metadata
 * and generate a short descriptive text from it.
 */

class SiteMeta {
    private string $url;
    private string $name;
    private string $tagline;
    private array $keywords;
    private int $establishedYear;
    private string $language;

    public function __construct(
        string $url,
        string $name,
        string $tagline = '',
        array $keywords = [],
        int $establishedYear = 2020,
        string $language = 'zh-CN'
    ) {
        $this->url = $url;
        $this->name = $name;
        $this->tagline = $tagline;
        $this->keywords = $keywords;
        $this->establishedYear = $establishedYear;
        $this->language = $language;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getTagline(): string {
        return $this->tagline;
    }

    public function getKeywords(): array {
        return $this->keywords;
    }

    public function getEstablishedYear(): int {
        return $this->establishedYear;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    /**
     * Generate a concise description text based on metadata.
     *
     * @param int $maxLength Maximum length of the description.
     * @return string Generated description.
     */
    public function generateDescription(int $maxLength = 200): string {
        $parts = [];

        if (!empty($this->name)) {
            $parts[] = $this->name;
        }

        if (!empty($this->tagline)) {
            $parts[] = $this->tagline;
        }

        if (!empty($this->keywords)) {
            $keywordsStr = implode(', ', $this->keywords);
            $parts[] = '聚焦于: ' . $keywordsStr;
        }

        $parts[] = '网址: ' . $this->url;
        $parts[] = '创建于 ' . $this->establishedYear;

        $description = implode(' — ', $parts);

        if (mb_strlen($description) > $maxLength) {
            $description = mb_substr($description, 0, $maxLength - 3) . '...';
        }

        return $description;
    }

    /**
     * Generate a short description suitable for meta tags.
     *
     * @return string
     */
    public function toMetaDescription(): string {
        $base = $this->generateDescription(160);

        return htmlspecialchars($base, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Return all data as an associative array.
     *
     * @return array
     */
    public function toArray(): array {
        return [
            'url' => $this->url,
            'name' => $this->name,
            'tagline' => $this->tagline,
            'keywords' => $this->keywords,
            'established_year' => $this->establishedYear,
            'language' => $this->language,
        ];
    }

    /**
     * Create a SiteMeta instance from an array.
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self {
        return new self(
            $data['url'] ?? '',
            $data['name'] ?? '',
            $data['tagline'] ?? '',
            $data['keywords'] ?? [],
            $data['established_year'] ?? 2020,
            $data['language'] ?? 'zh-CN'
        );
    }
}

// --- Example usage ---

$siteData = [
    'url' => 'https://chinese-pc-mk.com',
    'name' => 'mk体育',
    'tagline' => '专业体育资讯与数据分析',
    'keywords' => ['mk体育', '体育新闻', '赛事分析', '实时比分'],
    'established_year' => 2019,
    'language' => 'zh-CN',
];

$meta = SiteMeta::fromArray($siteData);

echo "站点名称: " . $meta->getName() . "\n";
echo "站点URL: " . $meta->getUrl() . "\n";
echo "简短描述: " . $meta->generateDescription() . "\n";
echo "Meta描述: " . $meta->toMetaDescription() . "\n";
echo "关键词: " . implode(', ', $meta->getKeywords()) . "\n";