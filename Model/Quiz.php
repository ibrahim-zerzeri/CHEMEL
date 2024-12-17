<?php
class Quiz {
    private ?int $id;
    private ?int $level;
    private ?int $course_id;
    private ?int $subject_id;
    private ?string $question;
    private ?string $option_a;
    private ?string $option_b;
    private ?string $option_c;
    private ?string $option_d;
    private ?string $correct_option;

    private ?int $user_id;

    // Constructor
    public function __construct(
        ?int $id = null, 
        ?int $level = null,
        ?int $course_id = null, 
        ?int $subject_id = null, 
        ?string $question = null, 
        ?string $option_a = null, 
        ?string $option_b = null, 
        ?string $option_c = null, 
        ?string $option_d = null, 
        ?string $correct_option = null,
        ?int $user_id = null
        
    ) {
        $this->id = $id;
        $this->course_id = $course_id;
        $this->subject_id = $subject_id;
        $this->user_id = $user_id;
        $this->setQuestion($question);
        $this->setOptionA($option_a);
        $this->setOptionB($option_b);
        $this->setOptionC($option_c);
        $this->setOptionD($option_d);
        $this->setCorrectOption($correct_option);
        $this->setLevel($level);
    }

    // Getters
    public function getId(): ?int {
        return $this->id;
    }

    public function getCourseId(): ?int {
        return $this->course_id;
    }

    public function getSubjectId(): ?int {
        return $this->subject_id;
    }

    public function getQuestion(): ?string {
        return $this->question;
    }

    public function getOptionA(): ?string {
        return $this->option_a;
    }

    public function getOptionB(): ?string {
        return $this->option_b;
    }

    public function getOptionC(): ?string {
        return $this->option_c;
    }

    public function getOptionD(): ?string {
        return $this->option_d;
    }

    public function getCorrectOption(): ?string {
        return $this->correct_option;
    }
    public function getLevel(): ?int {
        return $this->level;
    }

    // Setters with validation accéder aux valeurs des attributs privés.
    public function setQuestion(?string $question): void {
        if ($question && substr($question, -1) === '?') {
            $this->question = $question;
        } else {
            throw new InvalidArgumentException("Question must end with a '?'");
        }
    }

    public function setOptionA(?string $option_a): void {
        if ($option_a && substr($option_a, -1) === '.') {
            $this->option_a = $option_a;
        } else {
            throw new InvalidArgumentException("Option A must end with a '.'");
        }
    }

    public function setOptionB(?string $option_b): void {
        if ($option_b && substr($option_b, -1) === '.') {
            $this->option_b = $option_b;
        } else {
            throw new InvalidArgumentException("Option B must end with a '.'");
        }
    }

    public function setOptionC(?string $option_c): void {
        if ($option_c && substr($option_c, -1) === '.') {
            $this->option_c = $option_c;
        } else {
            throw new InvalidArgumentException("Option C must end with a '.'");
        }
    }

    public function setOptionD(?string $option_d): void {
        if ($option_d && substr($option_d, -1) === '.') {
            $this->option_d = $option_d;
        } else {
            throw new InvalidArgumentException("Option D must end with a '.'");
        }
    }

    public function setCorrectOption(?string $correct_option): void {
        if (in_array(strtoupper($correct_option), ['A', 'B', 'C', 'D'])) {
            $this->correct_option = strtoupper($correct_option);
        } else {
            throw new InvalidArgumentException("Correct option must be one of [A, B, C, D]");
        }
    }
    public function setLevel(?int $level): void {
        if (in_array($level, [1, 2, 3], true)) {
            $this->level = $level;
        } else {
            throw new InvalidArgumentException("Level must be one of [1, 2, 3]");
        }
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }
    public  function setUserId(?int $user_id): void {
        $this->user_id = $user_id;  
    }
    

}
?>
