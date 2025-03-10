<?php

    class Game {
    
        private $title;
        private $genre;
        private $platform;
        private $release_year;
        private $rating;
        private $image;
        private $description;
        private $developer;
    
    
    
        public function setTitle($title)
        {
            $this->title = $title;
        }
    
        public function getTitle()
        {
            return $this->title;
        }
    
        public function setGenre($genre)
        {
            $this->genre = $genre;
        }
    
        public function getGenre()
        {
            return $this->genre;
        }
    
        public function setPlatform($platform)
        {
            $this->platform = $platform;
        }
    
        public function getPlatform()
        {
            return $this->platform;
        }
    
        public function setRelease_year($release_year)
        {
            $this->release_year = $release_year;
        }
    
        public function getRelease_year()
        {
            return $this->release_year;
        }
    
        public function setRating($rating)
        {
            $this->rating = $rating;
        }
    
        public function getRating()
        {
            return $this->rating;
        }
        
        public function setImage($image)
        {
            $this->image = $image;
        }
    
        public function getImage()
        {
            return $this->image;
        }
        
        public function setDescription($description)
        {
            $this->description = $description;
        }
    
        public function getDescription()
        {
            return $this->description;
        }
        
        public function setDeveloper($developer)
        {
            $this->developer = $developer;
        }
    
        public function getDeveloper()
        {
            return $this->developer;
        }
   
    }
    
?>