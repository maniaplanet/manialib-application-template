<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Utils;

class StyleParser
{
	/**
	 * Constant to represent a style using a bit mask, color is on the 12 right bits
	 */
	const COLORED     = 0x1000;
	const ITALIC      = 0x2000;
	const BOLD        = 0x4000;
	const SHADOWED    = 0x8000;
	const WIDE        = 0x10000;
	const NARROW      = 0x20000;
	
	static private $gameProtocol = 'maniaplanet';
	static private $contrast = Color::CONTRAST_AUTO;
	static private $background = null;
	static private $fonts = array();

	static function getGameProtocol()
	{
		return self::$gameProtocol;
	}

	static function setGameProtocol($protocol)
	{
		self::$gameProtocol = $protocol;
	}

	static function getContrast()
	{
		return self::$contrast;
	}

	/**
	 * Colors which are too similar to the background will stay as they are
	 */
	static function contrastDisable()
	{
		self::$contrast = null;
	}

	/**
	 * Colors which are too similar to the background will be automaically contrasted
	 */
	static function contrastAuto()
	{
		self::$contrast = Color::CONTRAST_AUTO;
	}

	/**
	 * Colors which are too similar to the background will be always made darker
	 */
	static function contrastForceDarker()
	{
		self::$contrast = Color::CONTRAST_DARKER;
	}

	/**
	 * Colors which are too similar to the background will be always made darker
	 */
	static function contrastForceLighter()
	{
		self::$contrast = Color::CONTRAST_LIGHTER;
	}

	static function getBackground()
	{
		return self::$background;
	}

	/**
	 * Set the background color for contrasting colors
	 */
	static function setBackground($background)
	{
		self::$background = Color::StringToRgb24($background);
	}

	/**
	 * Declare a font to use with onImage function
	 */
	static function declareFont($name, $normal, $bold = null, $italic = null, $boldItalic = null)
	{
		$this->fonts[$name] = array(
			0 => $normal,
			StyleParser::BOLD => $bold ? : $normal,
			StyleParser::ITALIC => $italic ? : $normal,
			StyleParser::BOLD | StyleParser::ITALIC => $boldItalic ? : ($bold ? : ($italic ? : $normal))
		);
	}

	static function getFont($name, $style)
	{
		if(isset(self::$fonts[$name]))
			return self::$fonts[$name][$style];
		return null;
	}

	/**
	 * Get the html code of a string with style codes
	 */
	static function toHtml($string)
	{
		return implode('', self::parseString($string));
	}

	/**
	 * Draw a string with on an image, method will be choose depending on the size wanted
	 * @param string $string The style-coded string to draw
	 * @param imageResource $image The image to draw on
	 * @param string $fontName The TTF font to use, which has been declared previously
	 * @param int $x X position
	 * @param int $y Y position
	 * @param int $size	Font size
	 * @param string $defaultColor Default text color in 3 or 6 hexadecimal characters
	 */
	static function onImage($string, $image, $fontName, $x = 0, $y = 0, $size = 10, $defaultColor = '000')
	{
		if($size <= 5)
			self::onImageQuality($string, $image, $fontName, $x, $y, $size, $defaultColor, 3);
		else if($size <= 10)
			self::onImageQuality($string, $image, $fontName, $x, $y, $size, $defaultColor, 2);
		else if($size <= 20)
			self::onImageQuality($string, $image, $fontName, $x, $y, $size, $defaultColor, 1);
		else
			self::onImageFast($string, $image, $fontName, $x, $y, $size, $defaultColor);
	}

	/**
	 * Draw a string with on an image using fast method. There can be glitches when using small sizes
	 * @param string $string The style-coded string to draw
	 * @param imageResource $image The image to draw on
	 * @param string $fontName The TTF font to use, which has been declared previously
	 * @param int $x X position
	 * @param int $y Y position
	 * @param int $size	Font size
	 * @param string $defaultColor Default text color in 3 or 6 hexadecimal characters
	 */
	static function onImageFast($string, $image, $fontName, $x = 0, $y = 0, $size = 10, $defaultColor = '000')
	{
		$defaultColor = Color::StringToRgb24($defaultColor);

		$xOffset = 0;
		foreach(self::parseString($string) as $token)
			$xOffset += $token->onImage($image, $fontName, $x + $xOffset, $y, $size, $defaultColor, 1);
	}

	/**
	 * Draw a string with on an image using quality method. Slow with big text size
	 * @param string $string The style-coded string to draw
	 * @param imageResource $image The image to draw on
	 * @param string $fontName The TTF font to use, which has been declared previously
	 * @param int $x X position
	 * @param int $y Y position
	 * @param int $size	Font size
	 * @param string $defaultColor Default text color in 3 or 6 hexadecimal characters
	 * @param int $precision Higher value means higher precision (but also longer execution time), usual values are 1 to 3
	 */
	static function onImageQuality($string, $image, $fontName, $x = 0, $y = 0, $size = 10, $defaultColor = '000', $precision = 2)
	{
		$defaultColor = Color::StringToRgb24($defaultColor);
		$factor = 1 << ($precision > 31 ? 31 : $precision);

		$tokens = self::parseString($string);
		$rawText = '';
		foreach($tokens as $token)
			$rawText .= $token->text;
		$maxBBox = imagettfbbox($size, 0, self::$fonts[$fontName]->getFile(), $rawText);

		$brush = imagecreatetruecolor($maxBBox[2] * 2, -$maxBBox[5] + 5);
		imagefill($brush, 0, 0, 0x7fffffff);
		$hugeBrush = imagecreatetruecolor(imagesx($brush) * $factor, imagesy($brush) * $factor);
		imagefill($hugeBrush, 0, 0, 0x7fffffff);

		$xOffset = 0;
		foreach($tokens as $token)
			$xOffset += $token->onImage($hugeBrush, $fontName, $xOffset, imagesy($hugeBrush) * .75, $factor * $size, $defaultColor, $factor);

		$brushX = $x + imagesx($brush) / 2;
		$brushY = $y - imagesy($brush) * .25;
		imagecopyresampled($brush, $hugeBrush, 0, 0, 0, 0, imagesx($brush), imagesy($brush), imagesx($hugeBrush), imagesy($hugeBrush));
		imagesetbrush($image, $brush);
		imageline($image, $brushX, $brushY, $brushX, $brushY, IMG_COLOR_BRUSHED);
	}

	static private function parseString($string)
	{
		$rawTokens = preg_split('/(\$(?:[0-9a-f][^\$]{0,2}|[lhp](?:\[.*?\])?|.))/iu', $string, null, PREG_SPLIT_DELIM_CAPTURE);

		$stylesStack = array();
		$style = 0;
		$capitalized = false;
		$linkToken = null;
		$linkStartLevel = 0;
		$isManialink = false;
		$link = null;

		$tokens = array();
		$newToken = new TextToken();
		foreach($rawTokens as $rawToken)
		{
			if($rawToken === '')
				continue;
			if($rawToken[0] == '$')
			{
				switch(strtolower($rawToken[1]))
				{
					case 'i':
						$style ^= self::ITALIC;
						break;
					case 'o':
						$style ^= self::BOLD;
						break;
					case 's':
						$style ^= self::SHADOWED;
						break;
					case 'w':
						$style |= self::WIDE;
						$style &= ~self::NARROW;
						break;
					case 'n':
						$style |= self::NARROW;
						$style &= ~self::WIDE;
						break;
					case 'm':
						$style &= ~(self::NARROW | self::WIDE);
						break;
					case 't':
						$capitalized = !$capitalized;
						break;
					case 'g':
						$style &= empty($stylesStack) ? ~0x1fff : (end($stylesStack) | ~0x1fff);
						break;
					case 'z':
						$style = empty($stylesStack) ? 0 : end($stylesStack);

						if($linkToken)
						{
							if($newToken->text !== '')
							{
								$tokens[] = $newToken;
								if(!$linkToken->locked)
									$linkToken->link .= $newToken->text;
								$newToken = new TextToken($style);
							}
							else if(end($tokens) === $linkToken)
							{
								array_pop($tokens);
								$linkToken = null;
								break;
							}

							$tokens[] = new KnilToken();
							$linkToken = null;
						}
						break;

					case 'h':
					case 'p':
						$isManialink = true;
					case 'l':
						$matches = array();
						if(preg_match('/\[(.*?)\]/iu', $rawToken, $matches))
							$link = $matches[1];

						if($linkToken)
						{
							if($newToken->text !== '')
							{
								$tokens[] = $newToken;
								if(!$linkToken->locked)
									$linkToken->link .= $newToken->text;
								$newToken = new TextToken($style);
							}
							else if(end($tokens) === $linkToken)
							{
								array_pop($tokens);
								$linkToken = null;
								break;
							}

							$tokens[] = new KnilToken();
							if($link)
								$newToken->text = $link;
							$linkToken = null;
						}
						else
						{
							if($newToken->text)
							{
								$tokens[] = $newToken;
								$newToken = new TextToken($style);
							}
							$tokens[] = $linkToken = new LinkToken($link, $isManialink);
							$linkStartLevel = count($stylesStack);
						}

						$isManialink = false;
						$link = null;
						break;

					case '$':
						$newToken->text .= '$';
						break;
					case '<':
						array_push($stylesStack, $style);
						break;
					case '>':
						if(!empty($stylesStack))
						{
							$style = array_pop($stylesStack);
							
							if($linkToken && $linkStartLevel > count($stylesStack))
							{
								if($newToken->text !== '')
								{
									$tokens[] = $newToken;
									if(!$linkToken->locked)
										$linkToken->link .= $newToken->text;
									$newToken = new TextToken($style);
								}
								else if(end($tokens) === $linkToken)
								{
									array_pop($tokens);
									$linkToken = null;
									break;
								}

								$tokens[] = new KnilToken();
								$linkToken = null;
							}
						}
						break;

					case '0': case '1': case '2': case '3': case '4':
					case '5': case '6': case '7': case '8': case '9':
					case 'a': case 'b': case 'c': case 'd': case 'e':
					case 'f':
						$hexCode = preg_replace('/[^0-9a-f]/iu', '0', $rawToken);
						$style &= ~0xfff;
						$style |= self::COLORED | Color::StringToRgb12($hexCode);
				}

				if($style != $newToken->style)
				{
					if($newToken->text !== '')
					{
						$tokens[] = $newToken;
						if($linkToken && !$linkToken->locked)
							$linkToken->link .= $newToken->text;
						$newToken = new TextToken($style);
					}
					else
						$newToken->style = $style;
				}
			}
			else
				$newToken->text .= $capitalized ? strtoupper($rawToken) : $rawToken;
		}

		if($newToken->text !== '')
		{
			$tokens[] = $newToken;
			if($linkToken && !$linkToken->locked)
				$linkToken->link .= $newToken->text;
		}

		if($linkToken)
			$tokens[] = new KnilToken();

		return $tokens;
	}
}

class TextToken
{
	public $style;
	public $text;

	function __construct($style = 0, $text = '')
	{
		$this->style = $style;
		$this->text = $text;
	}

	function __toString()
	{
		if($this->style)
		{
			$styles = '';
			if($this->style & StyleParser::COLORED)
			{
				if(StyleParser::getBackground() !== null && StyleParser::getContrast() !== null)
				{
					$color = Color::Rgb12ToRgb24($this->style & 0xfff);
					$color = Color::Contrast($color, StyleParser::getBackground(), StyleParser::getContrast());
					$color = Color::Rgb24ToString($color);
				}
				else
					$color = Color::Rgb12ToString($this->style & 0xfff);
				$styles .= 'color:#'.$color.';';
			}
			if($this->style & StyleParser::ITALIC)
				$styles .= 'font-style:italic;';
			if($this->style & StyleParser::BOLD)
				$styles .= 'font-weight:bold;';
			if($this->style & StyleParser::SHADOWED)
				$styles .= 'text-shadow:1px 1px 1px rgba(0, 0, 0, 0.5);';
			if($this->style & StyleParser::WIDE)
				$styles .= 'letter-spacing:.1em;font-size:105%;';
			else if($this->style & StyleParser::NARROW)
				$styles .= 'letter-spacing:-.1em;font-size:95%;';
			return '<span style="'.$styles.'">'.htmlentities($this->text, ENT_QUOTES, 'UTF-8').'</span>';
		}
		else
			return htmlentities($this->text, ENT_QUOTES, 'UTF-8');
	}

	function onImage($image, $fontName, $x, $y, $size, $color, $shadowOffset)
	{
		$fontFile = StyleParser::getFont($fontName, $this->style & (StyleParser::BOLD | StyleParser::ITALIC));

		if($this->style & StyleParser::COLORED)
		{
			$color = Color::Rgb12ToRgb24($this->style & 0xfff);
			if(StyleParser::getBackground() !== null && StyleParser::getContrast() !== null)
				$color = Color::Contrast($color, StyleParser::getBackground(), StyleParser::getContrast());
		}

		$width = 0;
		$extraSpace = $size / 5;
		if($this->style & StyleParser::WIDE || $this->style & StyleParser::NARROW)
		{
			$ratio = ($this->style & StyleParser::WIDE) ? 1.5 : 1 / 1.5;
			$extraSpace *= $ratio;
			foreach((array) $this->text as $char)
			{
				$bBox = imagettfbbox($size, 0, $fontFile, $char);
				//echo print_r($bBox, true).'<br>';

				$temp = imagecreatetruecolor(($bBox[2] - $bBox[0]) * 2, ($bBox[3] - $bBox[5]) * 2);
				imagefill($temp, 0, 0, 0x7fffffff);
				$brush = imagecreatetruecolor(imagesx($temp) * $ratio, imagesy($temp));
				imagefill($brush, 0, 0, 0x7fffffff);
				$brushX = $x + $width + imagesx($brush) / 2;
				$brushY = $y;

				if($this->style & StyleParser::SHADOWED)
					imagettftext($temp, $size, 0, -$bBox[0] + $shadowOffset, $bBox[3] - $bBox[5] + $shadowOffset, 0x3f000000, $fontFile, $char);
				imagettftext($temp, $size, 0, -$bBox[0], $bBox[3] - $bBox[5], $color, $fontFile, $char);
				imagecopyresampled($brush, $temp, 0, 0, 0, 0, imagesx($brush), imagesy($brush), imagesx($temp), imagesy($temp));
				imagesetbrush($image, $brush);
				imageline($image, $brushX, $brushY, $brushX, $brushY, IMG_COLOR_BRUSHED);

				imagedestroy($temp);
				imagedestroy($brush);

				$width += ($bBox[2] - $bBox[0] + $extraSpace) * $ratio;
			}
		}
		else
		{
			foreach((array) $this->text as $char)
			{
				$bBox = imagettfbbox($size, 0, $fontFile, $char);

				if($this->style & StyleParser::SHADOWED)
					imagettftext($image, $size, 0, $x + $width - $bBox[0] + $shadowOffset, $y + $shadowOffset, 0x3f000000, $fontFile, $char);
				imagettftext($image, $size, 0, $x + $width - $bBox[0], $y, $color, $fontFile, $char);

				$width += $bBox[2] - $bBox[0] + $extraSpace;
			}
		}
		return $width;
	}
}

class LinkToken
{
	public $link;
	public $isManialink;
	public $locked;

	function __construct($link, $isManialink)
	{
		$this->link = $link;
		$this->isManialink = $isManialink;
		$this->locked = $link != null;
	}

	function __toString()
	{
		$link = $this->link;
		if($this->isManialink)
		{
			$protocol = StyleParser::getGameProtocol().'://';
			if(substr($link, 0, strlen($protocol)) != $protocol)
			{
				$link = StyleParser::getGameProtocol().':///:'.$link;
			}
		}
		else if(!preg_match('/^[a-z][a-z0-9+.-]*:\/\//ui', $link))
		{
			$link = 'http://'.$link;
		}
		$link = htmlentities($link, ENT_QUOTES, 'UTF-8');
		$target = $this->isManialink ? '' : 'target="_blank"';
		return sprintf('<a href="%s" %s>', $link, $target);
	}

	function onImage($image, Font $font, $x, $y, $size, $color, $shadowOffset)
	{
		return null;
	}
}

class KnilToken
{

	function __toString()
	{
		return '</a>';
	}

	function onImage($image, Font $font, $x, $y, $size, $color, $shadowOffset)
	{
		return null;
	}
}

?>
