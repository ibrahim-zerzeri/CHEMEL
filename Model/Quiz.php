    <?php
    class Quiz {
        private ?int $id;
        private ?int $course_id;
        private ?int $subject_id;
        private ?string $question;
        private ?string $option_a;
        private ?string $option_b;
        private ?string $option_c;
        private ?string $option_d;
        private ?string $correct_option;

        // Constructor
        public function __construct(
            ?int $id = null, 
            ?int $course_id = null, 
            ?int $subject_id = null, 
            ?string $question = null, 
            ?string $option_a = null, 
            ?string $option_b = null, 
            ?string $option_c = null, 
            ?string $option_d = null, 
            ?string $correct_option = null
        ) {
            $this->id = $id;
            $this->course_id = $course_id;
            $this->subject_id = $subject_id;
            $this->question = $question;
            $this->option_a = $option_a;
            $this->option_b = $option_b;
            $this->option_c = $option_c;
            $this->option_d = $option_d;
            $this->correct_option = $correct_option;
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

        // Setters
        public function setId(?int $id): void {
            $this->id = $id;
        }

        public function setCourseId(?int $course_id): void {
            $this->course_id = $course_id;
        }

        public function setSubjectId(?int $subject_id): void {
            $this->subject_id = $subject_id;
        }

        public function setQuestion(?string $question): void {
            $this->question = $question;
        }

        public function setOptionA(?string $option_a): void {
            $this->option_a = $option_a;
        }

        public function setOptionB(?string $option_b): void {
            $this->option_b = $option_b;
        }

        public function setOptionC(?string $option_c): void {
            $this->option_c = $option_c;
        }

        public function setOptionD(?string $option_d): void {
            $this->option_d = $option_d;
        }

        public function setCorrectOption(?string $correct_option): void {
            $this->correct_option = $correct_option;
        }
    }
    ?>
