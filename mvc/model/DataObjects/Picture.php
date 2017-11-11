<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:27
 */

class Picture
{
    private $id;
    private $tag;
    private $title;
    private $picture_blob;
    private $thumbnail_blob;

    private $picture;
    private $thumbnail;

    private $galleryId;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getTag()
    {
        return $this->tag;
    }
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getPictureBlob()
    {
        return $this->picture_blob;
    }
    public function setPictureBlob($picture_blob)
    {
        $this->picture_blob = $picture_blob;
    }
    public function getThumbnailBlob()
    {
        return $this->thumbnail_blob;
    }
    public function setThumbnailBlob($thumbnail_blob)
    {
        $this->thumbnail_blob = $thumbnail_blob;
    }
    public function getPicture()
    {
        return $this->picture;
    }
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }
    public function getGalleryId()
    {
        return $this->galleryId;
    }
    public function setGalleryId($galleryId)
    {
        $this->galleryId = $galleryId;
    }
}