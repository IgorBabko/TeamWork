<?php

namespace App\Transformers;

use App\Task;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'completed_flag' => $task->completed_flag
        ];
    }
}
