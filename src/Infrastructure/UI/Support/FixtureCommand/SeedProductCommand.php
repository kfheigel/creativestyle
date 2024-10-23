<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\Support\FixtureCommand;

use App\Domain\Entity\Product;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'support:fixture:product',
    description: 'Introduce Products',
)]
class SeedProductCommand extends Command
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command create products based on provided json export.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $availableProducts = $this->provideAvailableProducts();
        foreach ($availableProducts as $productData) {
            $product = new Product(
                $productData['name'],
                $productData['price'],
                Uuid::fromString($productData['id'])
            );

            $this->productRepository->save($product);
            $this->em->flush();

            $output->writeln(sprintf("%s product introduced", $product->getName()));
        }

        return Command::SUCCESS;
    }

    private function provideAvailableProducts(): array
    {
        $productJsonFile = __DIR__ . '/../../../../../fixtures/product/products.json';
        $jsonContent = file_get_contents($productJsonFile);

        if (!$jsonContent) {
            return [];
        }

        $products = json_decode($jsonContent, true);
        if (!is_array($products)) {
            return [];
        }

        return $products;
    }
}
