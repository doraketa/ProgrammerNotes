<?php
declare(strict_types=1);
namespace Adv\PartnersBundle\Partners\Asna\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Adv\PartnersBundle\Partners\Asna\Queue\OrdersQueueConsumer;
use Adv\PartnersBundle\Partners\Asna\Messages\ImportOrdersMessage;

class TestAsnaSimple extends Command
{
    public const COMMAND = 'partners:partners:asna:simpletest';
    private const DESCRIPTION = 'This command for testing purposes only, must be deleted';
    private $consumer;
    private $message;

    public function __construct(OrdersQueueConsumer $consumer, ImportOrdersMessage $message) {
        parent::__construct();
        $this->consumer = $consumer;
        $this->message = $message;
    }

    public function configure(): void
    {
        $this
            ->setName(self::COMMAND)
            ->setDescription(self::DESCRIPTION)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->consumer->msgImportOrders($this->message);
    }

}