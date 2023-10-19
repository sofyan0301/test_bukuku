<?php
//1 : Urutkan Dari angka terkecil ke terbesar:

$list_angka_min_max = [77, 11, 66, 75, 77, 1, 9, 3, 7, 58, 7, 69, 36, 9, 33, 33, 33, 31, 21, 98, 1];
for ($i = 0; $i < count($list_angka_min_max) - 1; $i++) {
    for ($j = 0; $j < count($list_angka_min_max) - 1; $j++) {
        if ($list_angka_min_max[$j] > $list_angka_min_max[$j + 1]) {
            $temp = $list_angka_min_max[$j + 1];
            $list_angka_min_max[$j + 1] = $list_angka_min_max[$j];
            $list_angka_min_max[$j] = $temp;
        }
    }

}
print_r('Data dari kecil ke besar :');
print_r($list_angka_min_max);
print_r('<br>');
print_r('<br>');

//2:  Urutkan Dari angka terbesar ke terkecil:

$list_angka_max_min = [77, 11, 66, 75, 77, 1, 9, 3, 7, 58, 7, 69, 36, 9, 33, 33, 33, 31, 21, 98, 1];
for ($i = 0; $i < count($list_angka_max_min) - 1; $i++) {
    for ($j = 0; $j < count($list_angka_max_min) - 1; $j++) {
        if ($list_angka_max_min[$j] < $list_angka_max_min[$j + 1]) {
            $temp = $list_angka_max_min[$j + 1];
            $list_angka_max_min[$j + 1] = $list_angka_max_min[$j];
            $list_angka_max_min[$j] = $temp;
        }
    }

}
print_r('Data dari besar ke kecil :');
print_r($list_angka_max_min);
print_r('<br>');
print_r('<br>');

//3 :Cek kata Palindrom, jika katanya palindrom, print "kata palindrom", jika bukan, print "bukan palindrom"

$text = 'malam';
$split_text = str_split($text);
$text_length = count($split_text) - 1;
$is_palindrom = true;
for ($i = 0; $i < count($split_text); $i++) {
    if ($split_text[$i] != $split_text[$text_length]) {
        $is_palindrom = false;
        break;
    }
    $text_length = $text_length - 1;
}

print_r('kata ' . $text . ($is_palindrom ? ' adalah palindrom' : ' bukan palindrom'));
print_r('<br>');
print_r('<br>');

// 4: Buat antrian dengan algoritma FIFO.

$data_input = [77, 11, 66, 75, 77, 1, 9, 3, 7, 58, 7, 69, 36, 9, 33, 33, 33, 31, 21, 98, 1];
$output_array = [];
$index_output = 0;
for ($i = 0; $i < count($data_input); $i++) {
    if (!count($output_array)) {
        $output_array[$index_output][] = $data_input[$i];
    } elseif (count($output_array[$index_output]) < 5) {
        $output_array[$index_output][] = $data_input[$i];
    } else {
        $index_output = $index_output + 1;
        $output_array[$index_output][] = $data_input[$i];
    }
}

print_r($output_array);
