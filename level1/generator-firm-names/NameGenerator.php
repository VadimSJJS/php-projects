<?php
class NameGenerator {
    
    private $userWords = [];
    private $category = 'tech';
    private $generatedNames = [];
    
    public function __construct($userWords = [], $category = 'tech') {
        $this->userWords = array_map('trim', $userWords);
        $this->category = $category;
    }
    
    public function generate($count = 5) {
        global $categories, $name_patterns, $adjectives, $names, $cities;
        $this->generatedNames = [];
        
        for ($i = 0; $i < $count; $i++) {
            $categoryData = $categories[$this->category];
            
            $prefix = $this->getRandomElement(array_merge($categoryData['prefixes'], $this->userWords));
            $suffix = $this->getRandomElement($categoryData['suffixes']);
            $adjective = $this->getRandomElement($adjectives);
            $name = $this->getRandomElement($names);
            $city = $this->getRandomElement($cities);
            
            $patternType = $this->getRandomElement(array_keys($name_patterns));
            $pattern = $this->getRandomElement($name_patterns[$patternType]);
            
            $generatedName = str_replace(
                ['{prefix}', '{suffix}', '{adjective}', '{name}', '{city}'],
                [$prefix, $suffix, $adjective, $name, $city],
                $pattern
            );
            
            $this->generatedNames[] = $generatedName;
        }
        
        return $this->generatedNames;
    }
    
    private function getRandomElement($array) {
        if (empty($array)) return '';
        return $array[array_rand($array)];
    }
    
    public function getGeneratedNames() {
        return $this->generatedNames;
    }
    
    public function getCategoryName() {
        global $categories;
        return isset($categories[$this->category]) ? $categories[$this->category]['name'] : 'Неизвестная категория';
    }
    
    public static function getCategoriesList() {
        global $categories;
        $result = [];
        foreach ($categories as $key => $data) {
            $result[$key] = $data['name'];
        }
        return $result;
    }
}