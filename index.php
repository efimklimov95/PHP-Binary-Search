<?php
function bin_search($file_name, $key) {
    $fopen = fopen($file_name, 'r');
    $tab = "\t";

    //Binary search indexes
    $low = 0;
    $high = filesize($file_name);

    while ($low <= $high) {
        //Middle index for binary search
        $mid = floor(($low + $high) / 2);

        //Setting pointer inside the file to position of middle index
        fseek($fopen, $mid);

        //Moving pointer to beginning of the line
        $offset = $mid;
        while(fgetc($fopen) != "\x0A" && $offset > 0) {
            fseek($fopen, $offset);
            $offset--;
        }
        //If pointer is at beginning of the file it's been moved 1 character forward due to fgetc($fopen) in previous cycle, thus it need to be moved back at position 0
        if ($offset == 0) {
            fseek($fopen, $offset);
        }

        //Reading the whole line that pointer stands at
        $line = fgets($fopen);

        //Exploding line into key-value pair
        $pair = explode($tab, $line);

        //Binary search
        if ($key == $pair[0]) {
            fclose($fopen);
            return $pair[1];
        } else if ($key < $pair[0]) {
            $high = $mid - 1;
        } else if ($key > $pair[0]) {
            $low = $mid + 1;
        }
    }
    //If the search hasn't found required key, closing file and returning "undef"
    fclose($fopen);
    return "undef";
}

echo bin_search("test_file.txt", "ключ7");
?>