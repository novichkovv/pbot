<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 22.05.2016
 * Time: 22:20
 */
class feed_class extends base
{
    public function getArticles($article_ids)
    {
        $res = [];
        $articles = [];
        $tmp = $this->model('articles')->getByFieldIn('entry_id', $article_ids, true);
        foreach ($tmp as $article) {
            $articles[$article['entry_id']] = $article;
        }
        $new_articles = [];
        foreach ($article_ids as $id) {
            if(!in_array($id, $articles)) {
                $new_articles[] = $id;
            } else {
                $res[$id] = $articles[$id];
            }
        }
        if($new_articles) {
            require_once(ROOT_DIR . 'classes' . DS . 'simple_html_dom_class.php');
            $tmp = $this->api()->getEntries($new_articles);
            foreach ($tmp as $article) {
                $content = $article['content']['content'];
                $html = str_get_html($content);
                $content = $html->root;
                $thumb = $content->find('img')[0]->src;
                $content->find('img')[0]->outertext = '';
                $row = [];
                $row['entry_id'] = $article['id'];
                $row['stream_id'] = $article['origin']['streamId'];
                $row['thumbnail'] = $thumb;
                $row['content'] = $content;
                $row['title'] = $article['title'];
                $row['summary'] = $article['summary']['content'];
                $row['keywords'] = implode(',', $article['keywords']);
                $row['author'] = $article['author'];
                $row['publish_date'] = date('Y-m-d H:i:s', round($article['published']/1000));
                $row['source_url'] = $article['canonicalUrl'];
                $row['create_date'] = date('Y-m-d H:i:s');
                $this->model('articles')->insert($row);
                $res[$row['entry_id']] = $row;
            }
        }
        return $res;
    }

    public function getFeeds($feeds_ids)
    {
        $res = [];
        $feeds = [];
        $tmp = $this->model('feeds')->getByFieldIn('feed_id', $feeds_ids, true);
        foreach ($tmp as $v) {
            $feeds[$v['feed_id']] = $v;
        }
        $new_feeds = [];
        $feeds_to_update = [];


    }
}