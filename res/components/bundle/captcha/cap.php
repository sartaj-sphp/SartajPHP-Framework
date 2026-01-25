<?php
class CaptchaSub {
    private $generatedValue = '';
    private $operators = ['+', '-', '×'];
    
    public function getGeneratedValue() {
        return $this->generatedValue;
    }
    
    private function generateMathExpression() {
        // Generate simple math problem instead of random string
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $operator = $this->operators[rand(0, 2)];
        
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                $expression = "$num1 + $num2";
                break;
            case '-':
                // Ensure positive result
                $num1 = max($num1, $num2) + rand(0, 3);
                $num2 = min($num1, $num2);
                $result = $num1 - $num2;
                $expression = "$num1 - $num2";
                break;
            case '×':
                // Simple multiplication (avoid large numbers)
                $num1 = rand(2, 5);
                $num2 = rand(2, 5);
                $result = $num1 * $num2;
                $expression = "$num1 × $num2";
                break;
            default:
                $result = $num1 + $num2;
                $expression = "$num1 + $num2";
        }
        
        $this->generatedValue = (string)$result;
        return $expression;
    }
    
    public function genImage() {
        $bpath = __DIR__;
        
        // Generate math expression instead of random string
        $expression = $this->generateMathExpression();
        
        // Create array of characters to display
        $chars = str_split($expression . ' = ?');
        $charCount = count($chars);
        
        // Use noise background
        $image = imagecreatefrompng("{$bpath}/res/noise.png");
        
        // Add more distortion for security
        $this->addDistortion($image);
        
        // Define colors with better contrast
        $colors = [
            [30, 30, 30],   // Dark gray
            [0, 100, 0],    // Dark green
            [139, 0, 0],    // Dark red
            [0, 0, 139],    // Dark blue
            [128, 0, 128],  // Purple
            [0, 0, 0],      // Black
        ];
        
        // Add random lines for more noise
        $this->addRandomLines($image);
        
        // Draw each character
        $x = 10;
        $y = 35;
        $size = 18;
        
        foreach ($chars as $index => $char) {
            //$font = "{$bpath}/fonts/" . rand(1, 2) . ".ttf";
            $font = "{$bpath}/fonts/1.ttf";
            $angle = rand(-15, 15);
            $colorIndex = rand(0, count($colors) - 1);
            $color = imagecolorallocate($image, 
                $colors[$colorIndex][0], 
                $colors[$colorIndex][1], 
                $colors[$colorIndex][2]
            );
            
            // Add slight character distortion
            $charX = $x + rand(-2, 2);
            $charY = $y + rand(-2, 2);
            
            imagettftext($image, $size, $angle, $charX, $charY, $color, $font, $char);
            
            // Move x position based on character width
            $bbox = imagettfbbox($size, 0, $font, $char);
            $charWidth = $bbox[2] - $bbox[0];
            $x += $charWidth + rand(1, 5);
        }
        
        // Add wave distortion
        $this->applyWaveEffect($image);
        
        // Output image
        ob_start();
        imagejpeg($image, null, 85); // 85% quality
        $image_data = ob_get_clean();
        imagedestroy($image);
        
        return base64_encode($image_data);
    }
    
    private function addDistortion(&$image) {
        $width = imagesx($image);
        $height = imagesy($image);
        
        // Add random dots
        for ($i = 0; $i < 100; $i++) {
            $color = imagecolorallocate($image, rand(150, 220), rand(150, 220), rand(150, 220));
            imagesetpixel($image, rand(0, $width), rand(0, $height), $color);
        }
    }
    
    private function addRandomLines(&$image) {
        $width = imagesx($image);
        $height = imagesy($image);
        
        for ($i = 0; $i < 5; $i++) {
            $color = imagecolorallocate($image, rand(180, 230), rand(180, 230), rand(180, 230));
            imageline($image, 
                rand(0, $width), rand(0, $height),
                rand(0, $width), rand(0, $height),
                $color
            );
        }
    }
    
private function applyWaveEffect(&$image) {
    $width = imagesx($image);
    $height = imagesy($image);
    $dest = imagecreatetruecolor($width, $height);
    
    // Use imagecopyresampled for better quality with float coordinates
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            // Calculate source coordinates with wave distortion
            $srcX = $x + sin($y / 10) * 2;
            $srcY = $y + cos($x / 15) * 1;
            
            // Ensure coordinates are within bounds
            if ($srcX >= 0 && $srcX < $width - 1 && $srcY >= 0 && $srcY < $height - 1) {
                // Get integer coordinates for interpolation
                $x1 = (int)floor($srcX);
                $x2 = (int)ceil($srcX);
                $y1 = (int)floor($srcY);
                $y2 = (int)ceil($srcY);
                
                // Simple bilinear interpolation
                $color1 = imagecolorat($image, $x1, $y1);
                $color2 = imagecolorat($image, $x2, $y1);
                $color3 = imagecolorat($image, $x1, $y2);
                $color4 = imagecolorat($image, $x2, $y2);
                
                // Average the colors (simple interpolation)
                $r = (($color1 >> 16) & 0xFF + ($color2 >> 16) & 0xFF + 
                      ($color3 >> 16) & 0xFF + ($color4 >> 16) & 0xFF) / 4;
                $g = (($color1 >> 8) & 0xFF + ($color2 >> 8) & 0xFF + 
                      ($color3 >> 8) & 0xFF + ($color4 >> 8) & 0xFF) / 4;
                $b = ($color1 & 0xFF + $color2 & 0xFF + $color3 & 0xFF + $color4 & 0xFF) / 4;
                
                $color = imagecolorallocate($dest, (int)$r, (int)$g, (int)$b);
                imagesetpixel($dest, $x, $y, $color);
            } else {
                // Use background color for out-of-bounds pixels
                $bgColor = imagecolorallocate($dest, 255, 255, 255);
                imagesetpixel($dest, $x, $y, $bgColor);
            }
        }
    }
    
    // Copy back to original image
    imagecopy($image, $dest, 0, 0, 0, 0, $width, $height);
    imagedestroy($dest);
}
    
}
