<?php

/**
 * SiteMeta - 站点元信息管理工具
 * 使用数组保存站点元数据，并提供生成简短描述文本的方法。
 */

class SiteMeta
{
    private array $meta;

    public function __construct(array $meta)
    {
        $this->meta = $meta;
    }

    /**
     * 生成简短描述文本
     * @return string
     */
    public function generateDescription(): string
    {
        $parts = [];

        if (!empty($this->meta['title'])) {
            $parts[] = $this->meta['title'];
        }

        if (!empty($this->meta['keywords'])) {
            $keywords = is_array($this->meta['keywords'])
                ? implode(', ', $this->meta['keywords'])
                : $this->meta['keywords'];
            $parts[] = '关键词: ' . $keywords;
        }

        if (!empty($this->meta['url'])) {
            $parts[] = '官网: ' . $this->meta['url'];
        }

        if (!empty($this->meta['description'])) {
            $parts[] = $this->meta['description'];
        }

        return implode(' | ', $parts);
    }

    /**
     * 获取某个元信息值
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->meta[$key] ?? $default;
    }

    /**
     * 设置某个元信息值
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * 导出全部元数据
     * @return array
     */
    public function toArray(): array
    {
        return $this->meta;
    }

    /**
     * 静态工厂：从默认数据创建实例
     * @return self
     */
    public static function createFromDefault(): self
    {
        $defaultMeta = [
            'title'       => '爱游戏 - 官方门户',
            'keywords'    => ['爱游戏', '游戏平台', '在线娱乐'],
            'url'         => 'https://mainportal-i-game.com.cn',
            'description' => '爱游戏提供丰富的游戏内容和优质的玩家体验。',
            'language'    => 'zh-CN',
            'author'      => '爱游戏团队',
            'version'     => '1.0.0',
        ];

        return new self($defaultMeta);
    }

    /**
     * 安全转义字符串（用于 HTML 输出）
     * @param string $value
     * @return string
     */
    public static function escapeHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

// 示例使用
$siteMeta = SiteMeta::createFromDefault();
$description = $siteMeta->generateDescription();

echo "站点描述: " . SiteMeta::escapeHtml($description) . "\n";
echo "标题: " . SiteMeta::escapeHtml($siteMeta->get('title')) . "\n";
echo "URL: " . SiteMeta::escapeHtml($siteMeta->get('url')) . "\n";