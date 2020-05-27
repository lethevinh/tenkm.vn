<?php

namespace App\Services;

class SEOTool
{
    public $title = '';

    public $description = '';

    public $keyword = '';

    public $image = '';

    public $published_time = '';

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        return $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        return $this->description = $description;
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function setKeyword($keyword)
    {
        return $this->keyword = $keyword;
    }

    public function getImage()
    {
        return !empty($this->image) ? $this->image : config('vi-admin.theme.logo');
    }

    public function setImage($image)
    {
        return $this->image = $image;
    }

    public function getPublished()
    {
        return $this->published_time;
    }

    public function setPublished($publishedTime)
    {
        return $this->published_time = $publishedTime;
    }

    public function render($data = [])
    {
        return view('partials.seo', array_merge([
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'keyword' => $this->getKeyword(),
            'image' => $this->getImage(),
            'published_time' => $this->getPublished(),
        ], $data));
    }
}
