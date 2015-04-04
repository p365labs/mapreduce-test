<?php

$lines = array(
             'one two three four one',
             'two three four',
             'three four',
             'four',
             );
// Desired Output, array of type word => count
// array ( 'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, ) 

// Transforms (Line of Words) -> (Array: Word => Count)
$lineToWordCounts = 
    function($line) { 
        return array_count_values(explode(' ', $line));
    };
    
// Test on a single line:
var_export($lineToWordCounts('one two three four'));
// Output: array ( 'one' => 1, 'two' => 1, 'three' => 1, 'four' => 1, )

// Test with array_map:
$counts = array_map($lineToWordCounts, $lines);
var_export($counts);
// Output: array ( 0 => array ( 'one' => 1, 'two' => 1, 'three' => 1, 'four' => 1, ), 
//                 1 => array ( 'two' => 1, 'three' => 1, 'four' => 1, ),
//                 2 => array ( 'three' => 1, 'four' => 1, ),
//                 3 => array ( 'four' => 1, ), )

// Combiner (Array:Word=>Count,Array:Word=>Count)->(Array:Word=>Count)
$sumWordCounts =
    function($countsL, $countsR) {
        // Get all the words
        $words = array_merge(array_keys($countsL), array_keys($countsR));
        $out = array();
        // Put them in a new (Array: Word => Count)
        foreach($words as $word) {
            // Sum their counts
            $out[$word] = isset($countsL[$word]) ? $countsL[$word] : 0;
            $out[$word] += isset($countsR[$word]) ? $countsR[$word] : 0;
        }
        return $out;
    };
$totals = array_reduce($counts, $sumWordCounts, array());
var_export($totals);
// Output: array ( 'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, ) 
