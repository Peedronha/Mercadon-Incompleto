<?php
    function steganize($message)
{
    $file = "..//imagens/background.jpg";

    // Encode the message into a binary string.
    $binaryMessage = '';
    for ($i = 0; $i < mb_strlen($message); ++$i) {
        $character = ord($message[$i]);
        $binaryMessage .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
    }

    // Inject the 'end of text' character into the string.
    $binaryMessage .= '00000011';

    // Load the image into memory.
    $img = imagecreatefrompng($file);

    // Get image dimensions.
    $width = imagesx($img);
    $height = imagesy($img);

    $messagePosition = 0;

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {

            if (!isset($binaryMessage[$messagePosition])) {
                // No need to keep processing beyond the end of the message.
                break 2;
            }

            // Extract the colour.
            $rgb = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $rgb);

            $red = $colors['red'];
            $green = $colors['green'];
            $blue = $colors['blue'];
            $alpha = $colors['alpha'];

            // Convert the blue to binary.
            $binaryRed = str_pad(decbin($red), 8, '0', STR_PAD_LEFT);
            $binaryGreen = str_pad(decbin($green), 8, '0', STR_PAD_LEFT);
            $binaryBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT);

            // Replace the final bit of the blue colour with our message.
            $binaryRed[strlen($binaryRed) - 1] = $binaryMessage[$messagePosition];
            $newRed = bindec($binaryRed);
            $binaryGreen[strlen($binaryGreen) - 1] = $binaryMessage[$messagePosition];
            $newGreen = bindec($binaryGreen);
            $binaryBlue[strlen($binaryBlue) - 1] = $binaryMessage[$messagePosition];
            $newBlue = bindec($binaryBlue);
            // Inject that new colour back into the image.
            $newColor = imagecolorallocatealpha($img, $newRed, $newGreen, $newBlue, $alpha);
            imagesetpixel($img, $x, $y, $newColor);

            // Advance message position.
            $messagePosition++;
        }
    }

    // Save the image to a file.
    $newImage = 'secret.png';
    rename($newImage, '/Mercadon/imagens/secret.png');
    imagepng($img, $newImage, 9);

    // Destroy the image handler.
    imagedestroy($img);
}
function desteganize($file)
{
    // Read the file into memory.
    $img = imagecreatefrompng($file);

    // Read the message dimensions.
    $width = imagesx($img);
    $height = imagesy($img);

    // Set the message.
    $binaryMessage = '';

    // Initialise message buffer.
    $binaryMessageCharacterParts = [];

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {

            // Extract the colour.
            $rgb = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $rgb);

            $red = $colors['red'];
            $green = $colors['green'];
            $blue = $colors['blue'];

            // Convert the blue to binary.
            $binaryRed = decbin($red);
            $binaryGreen = decbin($green);
            $binaryBlue = decbin($blue);

            // Extract the least significant bit into out message buffer..

            $binaryMessageCharacterPartsRed[] = $binaryRed[strlen($binaryRed) - 1];
            $binaryMessageCharacterPartsGreen[] = $binaryGreen[strlen($binaryGreen) - 1];
            $binaryMessageCharacterPartsBlue[] = $binaryBlue[strlen($binaryBlue) - 1];


            if (count($binaryMessageCharacterPartsRed) == 8) {
                // If we have 8 parts to the message buffer we can update the message string.
                $binaryCharacter = implode('', $binaryMessageCharacterPartsRed);
                $binaryMessageCharacterPartsRed = [];
                if ($binaryCharacter == '00000011') {
                    // If the 'end of text' character is found then stop looking for the message.
                    break 2;
                } else {
                    // Append the character we found into the message.
                    $binaryMessage .= $binaryCharacter;
                }
            }
            if (count($binaryMessageCharacterPartsGreen) == 8) {
                // If we have 8 parts to the message buffer we can update the message string.
                $binaryCharacter = implode('', $binaryMessageCharacterPartsGreen);
                $binaryMessageCharacterPartsGreen = [];
                if ($binaryCharacter == '00000011') {
                    // If the 'end of text' character is found then stop looking for the message.
                    break 2;
                } else {
                    // Append the character we found into the message.
                    $binaryMessage .= $binaryCharacter;
                }
            }
            if (count($binaryMessageCharacterPartsBlue) == 8) {
                // If we have 8 parts to the message buffer we can update the message string.
                $binaryCharacter = implode('', $binaryMessageCharacterPartsBlue);
                $binaryMessageCharacterPartsBlue = [];
                if ($binaryCharacter == '00000011') {
                    // If the 'end of text' character is found then stop looking for the message.
                    break 2;
                } else {
                    // Append the character we found into the message.
                    $binaryMessage .= $binaryCharacter;
                }
            }
        }
    }

    // Convert the binary message we have found into text.
    $message = '';
    for ($i = 0; $i < strlen($binaryMessage); $i += 24) {
        $character = mb_substr($binaryMessage, $i, 24);
        $message .= chr(bindec($character));
    }

    return $message;
}

?>