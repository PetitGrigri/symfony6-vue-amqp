<?php

namespace App\Service;

use App\Entity\Task;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackHeaderBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackDividerBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;

class NotifierService
{
    public function __construct(
        private ChatterInterface $chatter,
    )
    { }
    
    public function notifyTaskStarted(Task $task) 
    {
        $chatMessage = (new ChatMessage(''))
            ->options(
                (new SlackOptions())
                    ->block(new SlackHeaderBlock('New task started'))
                    ->block(new SlackDividerBlock())
                    ->block(
                        (new SlackSectionBlock())
                            ->field('*Name*')
                            ->field($task->getName())
                            ->field('*Id*')
                            ->field($task->getId())
                            ->field('*Finished at*')
                            ->field($task->getStartedAt()->format('d/m/Y y:m:s'))
            
            )
        );
    
        $this->chatter->send($chatMessage);
    }

    public function notifyTaskFinished(Task $task) 
    {
        $chatMessage = (new ChatMessage(''))
        ->options(
            (new SlackOptions())
                ->block((new SlackHeaderBlock('Task finised')))
                ->block(new SlackDividerBlock())
                ->block(
                    (new SlackSectionBlock())
                        ->field('*Name*')
                        ->field($task->getName())
                        ->field('*Id*')
                        ->field($task->getId())
                        ->field('*Finished at*')
                        ->field($task->getFinishedAt()->format('d/m/Y y:m:s'))
                )
        );   
        
        $this->chatter->send($chatMessage);
    }
}
