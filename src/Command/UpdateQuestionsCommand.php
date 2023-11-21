<?php

namespace App\Command;

use App\Consumer\File\QuestionDto;
use App\Consumer\File\QuestionsWrapperDto;
use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:update-questions',
    description: 'Adds new questions to the database.',
)]
class UpdateQuestionsCommand extends Command
{
    const QUESTIONS_PATH = __DIR__ . '/../../questions.json';

    public function __construct(
        protected EntityManagerInterface $em,
        protected SerializerInterface $serializer,
        protected QuestionRepository $questionRepository,
        protected AnswerRepository $answerRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        if (file_exists(self::QUESTIONS_PATH)) {
            foreach ($this->getQuestionsFromFile() as $question) {
                $dbQuestion = $this->questionRepository->findOneBy(['question' => $question->getQuestion()]);
                if (!$dbQuestion) {
                    $this->insertNewQuestionToDb($question);
                }
            }
        } else {
            $io->error(sprintf('Question-File not found: %s', self::QUESTIONS_PATH));
            return Command::FAILURE;
        }
        $io->success('Questions successfully updated!');
        return Command::SUCCESS;
    }

    /**
     * @return QuestionDto[]
     */
    protected function getQuestionsFromFile(): array {
        $questionsWrapper = $this->serializer->deserialize(
            file_get_contents(self::QUESTIONS_PATH),
            QuestionsWrapperDto::class,
            'json'
        );
        assert($questionsWrapper instanceof QuestionsWrapperDto);
        return $questionsWrapper->getQuestions();
    }

    protected function insertNewQuestionToDb(QuestionDto $question): void {
        $dbQuestion = new Question();
        $dbQuestion->setQuestion($question->getQuestion());
        array_map(fn($a) => $dbQuestion->addAnswer(new Answer($a)), $question->getAnswers());
        $this->em->persist($dbQuestion);
        $this->em->flush();
        $dbQuestion->setRightAnswer($this->answerRepository->findOneBy([
            'answer' => $question->getAnswers()[$question->getRightAnswer()]
        ]));
        $this->em->flush();
    }
}
