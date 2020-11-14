<?php

namespace App\Command;

use App\Dto\Comment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class TestSerializerCommand extends Command
{
    protected static $defaultName = 'test:serializer';
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct();

        $this->serializer = $serializer;
    }

    protected function configure()
    {
        $this->setDescription('Add a short description for your command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Symfony serializer testing');

        $io->section('Single object denormalization');

        $commentArrayNormalized = [
            [
                "name" => "Kostin Aleksey",
                "notes" => "rwltiughe",
                "page_uid" => "cb72865d-6ac5-4c7c-8029-bf8a5db8e454",
                "created_at" => "2020-11-14 09:06:37",
            ],
            [
                "name" => "ervs",
                "notes" => "ev",
                "page_uid" => "cb72865d-6ac5-4c7c-8029-bf8a5db8e454",
                "created_at" => "2020-11-14 11:39:15",
            ],
            [
                "name" => "ergfwerg",
                "notes" => "wergwe",
                "page_uid" => "cb72865d-6ac5-4c7c-8029-bf8a5db8e454",
                "created_at" => "2020-11-14 11:39:10",
            ],
        ];

        $commentDenormalized = $this->serializer->denormalize($commentArrayNormalized[0], Comment::class);
        dump($commentDenormalized);
        $io->newLine();

        $io->section('Array of objects denormalization');

        $commentArrayDenormalized = $this->serializer->denormalize($commentArrayNormalized, Comment::class . '[]');
        dump($commentArrayDenormalized);
        $io->newLine();

        $io->section('Single object normalization');

        $commentDenormalized = new Comment();
        $commentDenormalized->setName('Kostin');
        $commentDenormalized->setNotes('Test comment');
        $commentDenormalized->setPageUid('6b229dfc-a58b-4335-9fb4-d14d087db331');

        $commaneNormalized = $this->serializer->normalize($commentDenormalized, null, [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt'],
        ]);
        dump($commaneNormalized);
        $io->newLine();

        return Command::SUCCESS;
    }
}
