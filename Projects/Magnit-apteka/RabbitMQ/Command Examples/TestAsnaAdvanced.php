<?php
declare(strict_types=1);
namespace Adv\PartnersBundle\Partners\Asna\Command;

use Adv\PartnersBundle\Backend\BackendInterface;
use Adv\PartnersBundle\Backend\Dto\TokenDto;
use Adv\PartnersBundle\Helpers\TokenHelper;
use Adv\PartnersBundle\Partners\Asna\PartnerInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Adv\PartnersBundle\Partners\Asna\Queue\QueueProducer;
use Adv\PartnersBundle\Partners\Asna\Messages\ImportOrdersMessage;
use Adv\PartnersBundle\Partners\Asna\API;

class TestAsnaAdvanced extends Command
{
    public const COMMAND = 'partners:partners:asna:testadvanced';
    private const DESCRIPTION = 'This command for testing purposes only, must be deleted';
    private $producer;
    private $message;

    /**
     * @var BackendInterface
     */
    private $backend;
    /**
     * @var API
     */
    private $api;

    public function __construct(API $api, BackendInterface $backend, QueueProducer $producer, ImportOrdersMessage $message) {
        parent::__construct();
        $this->producer = $producer;
        $this->message = $message;
        $this->backend = $backend;
        $this->api = $api;
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
        $this->api->setPasswords($this->backend->getPasswords(PartnerInfo::getName()));
        $this->api->setOldTokens(TokenHelper::loadTokens(PartnerInfo::getName()));

        $this->message->setPharmacyCode('903980');
        $this->message->setStoreId('d1c4057d-69b9-40d9-ac58-20c2bf97048e');
        $this->message->setPassword('cFlDc0RrVUp5MWhjZEdKK3J1YkcyZz09');
        $this->message->setToken((new TokenDto)->setToken('test')->setClientId('TestClient'));
        $this->producer->queueImportOrders($this->message);
    }
}