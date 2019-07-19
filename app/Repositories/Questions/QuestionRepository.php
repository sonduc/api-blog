<?php 

namespace App\Repositories\Questions;

use App\Repositories\BaseRepository;
use App\Repositories\Questions\Question;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
	/**
     * Role model.
     * @var Model
     */
    protected $model;

    /**
     * CategoryRepository constructor.
     *
     */
    public function __construct(Question $question)
    {
        $this->model = $question;
    }
}