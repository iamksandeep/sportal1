<?php

/**
 * Parses a string, and replaces occurences of the type:
 * :application_x:, :user_x:, etc with their links
 */
class SmartContentParser {

    static private function getClassName($string) {
        $classes = array(
            'application' => 'Application',
            'applicationTask' => 'ApplicationTask',
            'user' => 'User',
            'document' => 'Document',
            'app' => 'Application',
            'cli' => 'ApplicationTask',
            'usr' => 'User',
            'doc' => 'Document',
        );

        return isset($classes[$string]) ? $classes[$string] : null;
    }

    static public function parse($content) {
        $modifiedContent = $content;
        $pattern = "/\:[\w]+\_[\d]+\:/";
        preg_match_all($pattern, $content, $matches);

        foreach($matches[0] as $m) {
            $pieces = explode('_', substr($m, 1, -1));
            $class = self::getClassName($pieces[0]);

            if($class) {
                $id = $pieces[1];
                $parsedString = $class::getLinkFor($id);
                if($parsedString)
                    $modifiedContent = str_replace($m, $parsedString, $modifiedContent, $count);
            }
        }

        return $modifiedContent;
    }
}
