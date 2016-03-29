<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('rate_feedback'))
{
	function rate_feedback($str, $verbose = false)
	{
		$positive_words = array("good", "goo+d", "better", "best", "great", "gre+a+t+", "greater", "greatest", "clean", "cleaner", "cleanest", "yummy", "yummier", "yummiest", "cheerful", "efficient", "well", "right", "courteous", "super fast", "fast", "super", "superfast", "free", "fixed", "easy", "thank", "thanks", "rock", "rocks", "sparkly", "appreciate", "professional", "pro", "nice", "nicer", "nicest", "tasty", "tastey", "quick", "quickly", "quicker", "quickest", "rapid", "cute", "cutest", "smiley", "smile", "smiling", "smily", "like", "liked", "likes", "love", "loved", "loves", "loving","pretty cool", "pretty good", "pretty", "prettier", "prettiest", "available", "glad", "happy", "happier", "happiest", "thrilled", "excelent", "excellent", "attractive", "juicy", "welcome", "welcomed", "welcoming", "pleasant", "listened", "listens", "listen", "sexy", "sexier", "sexiest", "hot", "hottest", "care", "careful", "carefull", "appropriate", "ripe", "favorite", "willing", "fresh", "perfect", "perfectly", "crisp", "cripsy", "exceptional", "spotless", "immediate", "immediately", "delicious", "delish", "promote", "huge", "big", "top", "fun", "awesome", "awesom", "polite", "helpful", "thx", "amazing", "heaven", "sweethear", "sweet", "repeat", "kind", "wonderful", "attentive", "ready", "superb", "glossy", "glossiest", "a\+", "return", "enjoyed", "enjoyable", "enjoys", "enjoy", "ingenious", "friendly", "enough", "flavored", "everyday", "safe", "fantastic", "beautiful", "politely", "offer", "offered", "apologized", "persistent", "cool", "coolest", "lucky", "luv", "luvs", "fabulous", "bonus", "knowledgable", "thorough", "outstanding", "patient", "responsible", "5 stars", "five stars", "accommodating", "comfortable", "comfortably", "quite", "positive", "5=Excellent",  
		"the bomb", "da bomb", "to die for", "look forward", "looks forward", "looked forward", "always come", "always coming", "come back","coming back", "on time", "every week", "come again", "kicks butt", "beyond serving", "check on us", "pays attention to", "pay attention to", "anyone will go", "deserves a bonus", "deserve a bonus", "deserves a raise", "deserve a raise", "to remember", "top notch", "order it again", "order again", "speak english", "speaks english","speaking english", "spoke english", "spoken english");
		
		$negative_words = array("bad", "ba+d", "worse", "worst", "dirty", "dirtier", "dirtiest", "stinked", "smells", "smelly", "smelled", "stink", "stinks", "stinky", "loud", "sneeze", "terrible", "terible", "terrible", "disruptive", "raw", "cold", "broken", "awful", "shitty", "overcooked", "undercooked", "burned", "burnt", "burn", "burns", "horrible", "wrong", "overflowing", "overflow", "overflows", "weak", "hate", "hated", "dispise", "despise", "ruin", "ruined", "filthy", "slow", "vomit", "cockroach", "bugs", "bug", "cockroaches", "mouse", "mise", "rat", "rats", "mean", "rude", "difficult", "replace", "trash", "hard", "hardly", "afraid", "soggy", "falling", "plugged", "unavailable", "full", "stale", "crappy", "creepy", "sticky", "clogged", "should", "need to", "needs to", "you have to", "has to", "nobody", "sticks", "dripping", "drippy", "missing", "graffiti", "grafiti", "forgot", "forget", "screams", "scream", "screaming", "forgetting", "noisy", "unpleasent", "unpleasant", "intrusive", "bothersome", "obnoxious", "drop", "drops", "dropping", "dropped", "reuse", "smoke", "smoking", "smokes", "cigarette", "demanded", "a hair", "choking", "hazard", "tasteless", "break", "broke", "breaks", "bored", "refused", "rotten", "disrupting", "rushed", "smudge", "smudges", "smudged", "dangerous", "hazardous", "scary", "scarey", "poison", "poisoning", "poisinous", "diarreah", "dysentery", "rip", "ripped", "watery", "racist", "racism", "crumbs", "dead", "disgusting", "fix", "unappetizing", "unapetizing", "unusable", "shortchanged", "mistake", "mistaken", "cussing", "cusses", "swearing", "cursing", "temper", "carved", "spiders", "spider", "wet", "slippery", "piling", "lazy", "full", "tired", "mushy", "mooshy", "unsafe", "limp", "messy", "empty", "runny", "burning", "insulting", "humiliating", "frozen", "bacteria", "drip", "sick", "ache", "aches", "pain", "busy", "jerk", "scalding", "expensive", "fire", "poor", "rubbery", "robbery", "homeless", "flimsy", "ugly", "mess", "gooey", "spiderwebs", "grumpy", "angry", "grease", "greasy", "greesy", "far", "gum", "old", "tough", "blast", "complained", "complains", "complaints", "complain", "minutes", "shit", "sh\*t", "bitch", "b\*tch", "fuck", "fucker", "f\*ck", "f\**k", "f\*cker", "bitchy", "b\*tchy", "forced", "freezing", "salty", "fail", "failure", "waisted", "uninviting", "Undercooked", "raw", "spilled", "upset", "sad", "voicing", "reluctant", "deceptive", "inappropriate", "flat", "rediculous", "pre-prepared", "embarrassing", "sucks", "sucked", "greed", "poorly", "shocked", "bitter", "miserable", "uncomfortable", "uncomfortably", "lack", "lacks", "late", "rough", "smoky", "bumpy", "lost", "disappointed","disappointing", 
		"ran out", "run out", "out of", "fall apart", "falls apart", "threw up", "throw up", "get rid of", "black widows", "black widow", "spider webs", "run over", "ran over", "piece of you know what", "wish .*better", "wish .*now", "really wish","wish you had", "wish they had", "please put", "please change", "please bring", "please turn", "please go", "found hair", "still waiting", 
		"what the heck", "what the hell", "where the heck", "where the hell", "Under cooked", "ran off with", "runs? off with", "did not eat", "have not eaten", "dont eat", "do not eat", "charging extra", "it was hot", "its hot", "could use some", "flavor is really bland", "could be better", "can be better",  
		"too hot", "too long", "too small", "too dry", "too much", "too steep", "too many", "too strong", "too dark", "too bright", "too cold", "too high", "too heavy",
		"to hot", "to long", "to small", "to dry", "to much", "to steep", "to many", "to strong", "to dark", "to bright", "to cold", "to high");
		
		//"no place" => negative, "place" is neutral
		$other_words = array("no flavor", "needs flavor", "need flavor", "no place", "no paper", "no toilet paper", "no napkins", "no ketchup", "no ice", "no fork", "no forks", "no spoon", "no spoons", "no knife", "no knives", "no cheese", "no mustard", "no mayonnaise", "no mayonaise", "no mayo", "no soap", "no apology", "no ac", "no a/c", "not have", "dont you have", "couldnt find", "could not find", "didnt find", "cant find", "no placard", "no placards", "need placard", "need placards", "not cooked", "instead of paper", "no salads?", "needs? salads?", "no desserts?", "needs? desserts?", "werent there", "wasnt there");
		
		$negation_words = array("no", "not", "isnt", "arent", "wasnt", "werent", "never", "dont", "doesnt", "didnt", "any", "neither", "wouldnt", "used to be");
		
		//making the comment lower case
		$str = strtolower($str);
		//deleting any email from the comment in case there's any (we don't want to rate emails)
		$str = preg_replace("#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#", "", $str);
		//deleting apostrophes " ' ", so we won't have to test the two cases for words who have them like (isn't => isnt)
		$str = str_replace("'", "", $str);
		//replacing some sentences
		$str = str_replace("pretty good", "good", $str);
		$str = str_replace("good quality", "good", $str);
		$str = str_replace("even", " ", $str);
		$str = preg_replace("# +#", " ", $str);
		$str = preg_replace("#\?+#", " qqquestion. ", $str);
		//breaking the comments into sentences, each new one is defined by ",", ".", "!", "?", "and", "but" or a new line ...etc
		$sentences = preg_split("#,+ *|\.+ *|\!+ *|\?+ *|and +|but +|anyway *|however *|any kind *|some kind of *|right here +|right there +|its like *|looks* like *|looked like *|felt like *|like this*|only *|seems* like*|seemed like*|of fire *|right now *|would be nice|would be better|so far *|lab costa mess *|asked for it well done *|well i *|as well *|\( *|\) *|\n+ *|\r+ *#" ,$str, -1, PREG_SPLIT_NO_EMPTY);
		
		if($verbose) var_dump($sentences);
		
		$n_ow = count($other_words);
		$n_pw = count($positive_words);
		$n_nw = count($negative_words);
		$n_no = count($negation_words);
		$results = array(); $r = 0; //the results array and its indice
		
		foreach($sentences as $sentence)
		{ 
			//we make sure we have a space after and before the first and last word, so we can look for words that aren't inside other words
			$sentence = ' '.$sentence.' ';
			if($verbose) echo '<br />'.$r.' : '.$sentence;
			//counters for good and bad words for each sentence
			$g = 0; 
			$b = 0;
			//checking for "other_words" (that are negative)
			for($i = 0; $i < $n_ow; $i++)
			{
				$b = $b + preg_match_all("# ".$other_words[$i]." #", $sentence, $k);
				$sentence = preg_replace("# ".$other_words[$i]." #", " ", $sentence);
			}
			
			//checking for "negation words"
			$no = 0; //counter for negation words
			for($i = 0; $i < $n_no; $i++)
			{
				if(preg_match("# ".$negation_words[$i]." #", $sentence) == 1) //if a negation word was found, we look for the first good or bad word that follows it, we count it and delete both the negation word and the good/bad word
				{
					$no_indice = strpos($sentence, ' '.$negation_words[$i].' ') + strlen($negation_words[$i]); //saving the indice of the negation word 
					$target_indice = -1;
					$target_word = '';
					$target_nature = -1;
					//looking for the nagtive/postive word with the smallest indice that is bigger than the indice of the negation word
					for($j = 0; $j < $n_pw; $j++) 
					{
						$pos = strpos($sentence, ' '.$positive_words[$j].' ', $no_indice);
						if($pos !== false)
						{
							if(($pos < $target_indice) || ($target_indice == -1))
							{
								$target_indice = $pos;
								$target_word = $positive_words[$j];
								$target_nature = 1;
							}
						}
					}
					for($j = 0; $j < $n_nw; $j++)
					{
						$pos = strpos($sentence, ' '.$negative_words[$j].' ', $no_indice);
						if($pos !== false)
						{
							if(($pos < $target_indice) || ($target_indice == -1))
							{
								$target_indice = $pos;
								$target_word = $negative_words[$j];
								$target_nature = -1;
							}
						}
					}
					
					if(($target_indice != -1) && (!empty($target_word)))//if a good/bad word was found
					{
						$sentence = preg_replace("# ".$negation_words[$i].".*".$target_word." #", " ", $sentence);
						if($target_nature == -1) $g++;
						if($target_nature == 1) $b++;
					}
				}
			}
			
			//checking for negative words
			for($i = 0; $i < $n_nw; $i++)
			{
				$b = $b + preg_match_all("# ".$negative_words[$i]." #", $sentence, $k);
				$sentence = preg_replace("# ".$negative_words[$i]." #", " ", $sentence);
			}
			
			//checking for positive words
			for($i = 0; $i < $n_pw; $i++)
			{
				$g = $g + preg_match_all("# ".$positive_words[$i]." #", $sentence, $k);
				$sentence = preg_replace("# ".$positive_words[$i]." #", " ", $sentence);
			}
			
			//if the sentence is a question, only bad words count
			if(preg_match("# qqquestion #", $sentence) == 1)
			{
				$g = 0;
			}
			
			$results[$r] = $g - $b*1000; $r++; //giving negative an index of 1000 to override positive
			if($verbose) echo '<br />'.$sentence.' - good: '.$g.' - bad: '.$b.'<br />';
		}
		if($verbose) var_dump($results);
		//var_dump($sentences);
		
		$result = 0; //the final result for the nature of the comment
		for($i = 0; $i < $r; $i++)
		{
			$result = $result + $results[$i];
		}
		
		if($result > 0) $result = 1;
		elseif($result < 0) $result = 2;
		
		if($result == 1)
			return 'positive';
		elseif($result == 2)
			return 'negative';
		else
			return 'neutral';
	}
}

if (!function_exists('check_for_critical_words'))
{
	function check_for_critical_words($comment, $critical_words_array) //returns true if comment contains a critical word, false otherwise
	{
		$feedback = strtolower($comment);
		$feedback = str_replace("'","",$feedback);
		foreach($critical_words_array as $critical_word)
		{
			if(strpos($feedback, strtolower($critical_word)) !== false)
				return true;
		}
		return false;
	}
}