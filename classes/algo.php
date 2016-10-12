<?php
define('ASSOC_NONE', 0);
define('ASSOC_LEFT', 1);
define('ASSOC_RIGHT', 2);


// array(10, ASSOC_RIGHT, true), // originally needed in c code for unary -
// operator => array(precedence, associativity, unary)
$operators = array('^' => array(9, ASSOC_RIGHT, false),
					'*' => array(8, ASSOC_LEFT, false),
					'/' => array(8, ASSOC_LEFT, false),
					'%' => array(8, ASSOC_LEFT, false),
					'+' => array(5, ASSOC_LEFT, false),
					'-' => array(5, ASSOC_LEFT, false),
					'(' => array(0, ASSOC_NONE, false),
					')' => array(0, ASSOC_NONE, false));


function precedence($opchar)
{
	global $operators;
	return $operators[$opchar][0];
}


function associativity($opchar)
{
	global $operators;
	return $operators[$opchar][1];
}


function unary($opchar)
{
	global $operators;
	return $operators[$opchar][2];
}


function is_operator($char)
{
	global $operators;
	return array_key_exists($char, $operators);
}


function starts_with($haystack, $needle)
{
	return !strncmp($haystack, $needle, strlen($needle));
}


function ends_with($haystack, $needle)
{
	return substr($haystack, -strlen($needle)) === $needle;
}


function array_peek($stack)
{
	return $stack[count($stack) - 1];
}


function postfix($expression)
{
	$expression = preg_replace('/\s+/', '', $expression);

	if (!starts_with($expression, '('))
	{
		$expression = '('.$expression;
	}

	if (!ends_with($expression, ')'))
	{
		$expression .= ')';
	}

	$stack = array();
	$output = array();
	$numtoken = '';

	for ($i = 0; $i < strlen($expression); $i++)
	{
		$char = $expression[$i];

		if (is_operator($char))
		{
			if ($numtoken != '')
			{
				$output[] = $numtoken;
				$numtoken = '';
			}

			if ($char == '(')
			{
				array_push($stack, $char);
			}
			else if ($char == ')')
			{
				while (count($stack) > 0 && ($top = array_peek($stack)) != '(')
				{
					$output[] = array_pop($stack);
				}

				array_pop($stack);
			}
			else
			{
				while (count($stack) > 0)
				{
					$peek = array_peek($stack);

					if (associativity($char) == ASSOC_LEFT && precedence($char) <= precedence($peek)
						|| associativity($char) == ASSOC_RIGHT && precedence($char) < precedence($peek))
					{
						$output[] = array_pop($stack);
					}
					else
					{
						break;
					}
				}

				array_push($stack, $char);
			}
		}
		else
		{
			$numtoken .= $char;
		}
	}

	while (count($stack) > 0)
	{
		if (array_peek($stack) == '(')
		{
			array_pop($stack);
		}
		else
		{
			$output[] = array_pop($stack);
		}
	}

	return $output;
}


function postfix_eval($postfix, $variables = array())
{
	$stack = array();

	foreach ($postfix as $token)
	{
		if (is_operator($token))
		{
			$second = array_pop($stack);
			$first = array_pop($stack);

			if ($second == null || $first == null)
			{
				continue; // we need two operands on the stack first
			}

			if (!is_numeric($first) && array_key_exists($first, $variables))
			{
				$first = $variables[$first];
			}

			if (!is_numeric($second) && array_key_exists($second, $variables))
			{
				$second = $variables[$second];
			}

			$result = 0;

			if ($token == '^')
			{
				$result = pow($first, $second);
			}
			else
			{
				$result = eval("return $first $token $second;");
			}

			array_push($stack, $result);
		}
		else
		{
			if (strlen($token) > 0)
			{
				array_push($stack, $token);
			}
		}
	}

	return array_pop($stack);
}


if (isset($_GET['expr']))
{
	$expression = $_GET['expr'];
	echo('Expression: '.$expression.'<br />');
	$postfix = postfix($expression);
	echo('Postfix: '.implode(' ', $postfix).'<br />');
	echo('Evaluation: '.postfix_eval($postfix, array('size' => 121)));
}
else
{
	echo(':( no expression? fux u');
}
?><?php
define('ASSOC_NONE', 0);
define('ASSOC_LEFT', 1);
define('ASSOC_RIGHT', 2);


// array(10, ASSOC_RIGHT, true), // originally needed in c code for unary -
// operator => array(precedence, associativity, unary)
$operators = array('^' => array(9, ASSOC_RIGHT, false),
					'*' => array(8, ASSOC_LEFT, false),
					'/' => array(8, ASSOC_LEFT, false),
					'%' => array(8, ASSOC_LEFT, false),
					'+' => array(5, ASSOC_LEFT, false),
					'-' => array(5, ASSOC_LEFT, false),
					'(' => array(0, ASSOC_NONE, false),
					')' => array(0, ASSOC_NONE, false));


function precedence($opchar)
{
	global $operators;
	return $operators[$opchar][0];
}


function associativity($opchar)
{
	global $operators;
	return $operators[$opchar][1];
}


function unary($opchar)
{
	global $operators;
	return $operators[$opchar][2];
}


function is_operator($char)
{
	global $operators;
	return array_key_exists($char, $operators);
}


function starts_with($haystack, $needle)
{
	return !strncmp($haystack, $needle, strlen($needle));
}


function ends_with($haystack, $needle)
{
	return substr($haystack, -strlen($needle)) === $needle;
}


function array_peek($stack)
{
	return $stack[count($stack) - 1];
}


function postfix($expression)
{
	$expression = preg_replace('/\s+/', '', $expression);

	if (!starts_with($expression, '('))
	{
		$expression = '('.$expression;
	}

	if (!ends_with($expression, ')'))
	{
		$expression .= ')';
	}

	$stack = array();
	$output = array();
	$numtoken = '';

	for ($i = 0; $i < strlen($expression); $i++)
	{
		$char = $expression[$i];

		if (is_operator($char))
		{
			if ($numtoken != '')
			{
				$output[] = $numtoken;
				$numtoken = '';
			}

			if ($char == '(')
			{
				array_push($stack, $char);
			}
			else if ($char == ')')
			{
				while (count($stack) > 0 && ($top = array_peek($stack)) != '(')
				{
					$output[] = array_pop($stack);
				}

				array_pop($stack);
			}
			else
			{
				while (count($stack) > 0)
				{
					$peek = array_peek($stack);

					if (associativity($char) == ASSOC_LEFT && precedence($char) <= precedence($peek)
						|| associativity($char) == ASSOC_RIGHT && precedence($char) < precedence($peek))
					{
						$output[] = array_pop($stack);
					}
					else
					{
						break;
					}
				}

				array_push($stack, $char);
			}
		}
		else
		{
			$numtoken .= $char;
		}
	}

	while (count($stack) > 0)
	{
		if (array_peek($stack) == '(')
		{
			array_pop($stack);
		}
		else
		{
			$output[] = array_pop($stack);
		}
	}

	return $output;
}


function postfix_eval($postfix, $variables = array())
{
	$stack = array();

	foreach ($postfix as $token)
	{
		if (is_operator($token))
		{
			$second = array_pop($stack);
			$first = array_pop($stack);

			if ($second == null || $first == null)
			{
				continue; // we need two operands on the stack first
			}

			if (!is_numeric($first) && array_key_exists($first, $variables))
			{
				$first = $variables[$first];
			}

			if (!is_numeric($second) && array_key_exists($second, $variables))
			{
				$second = $variables[$second];
			}

			$result = 0;

			if ($token == '^')
			{
				$result = pow($first, $second);
			}
			else
			{
				$result = eval("return $first $token $second;");
			}

			array_push($stack, $result);
		}
		else
		{
			if (strlen($token) > 0)
			{
				array_push($stack, $token);
			}
		}
	}

	return array_pop($stack);
}


if (isset($_GET['expr']))
{
	$expression = $_GET['expr'];
	echo('Expression: '.$expression.'<br />');
	$postfix = postfix($expression);
	echo('Postfix: '.implode(' ', $postfix).'<br />');
	echo('Evaluation: '.postfix_eval($postfix, array('size' => 121)));
}
else
{
	echo(':( no expression? fux u');
}
?>
