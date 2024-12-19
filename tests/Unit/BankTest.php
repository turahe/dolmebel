<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Bank;
use App\Models\User;
use App\Repositories\BankRepository;
use Database\Factories\BankFactory;
use Database\Factories\UserFactory;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tests\TestCase;
use Turahe\Master\Seeds\BanksTableSeeder;

class BankTest extends TestCase
{
    protected $bank;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BanksTableSeeder::class);
        $this->bank = \Turahe\Master\Models\Bank::first();
        $this->user = UserFactory::new()->create();
    }

    public function test_return_empty_banks_collection_when_eloquent_has_no_banks(): void
    {
        $this->assertEmpty($this->user->banks);

    }

    public function test_cannot_get_the_bank(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $brandRepo = new BankRepository(new Bank);
        $brandRepo->getBank('not-a-bank');

    }

    public function test_can_list_all_banks(): void
    {

        BankFactory::new()->count(6)->create([
            'holder_type' => $this->user->getMorphClass(),
            'holder_id' => $this->user->getKey(),
            'bank_id' => $this->bank->code,
        ]);

        $bankRepo = new BankRepository(new Bank);
        $banks = $bankRepo->getBanks();

        $this->assertInstanceOf(Collection::class, $banks);
        $this->assertCount(6, $banks->all()); // +1 in the TestCase
    }

    public function test_can_delete_the_bank(): void
    {
        $bank = BankFactory::new()->createOne([
            'holder_type' => $this->user->getMorphClass(),
            'holder_id' => $this->user->getKey(),
            'bank_id' => $this->bank->getKey(),
        ]);

        $bankRepo = new BankRepository($bank);
        $deleted = $bankRepo->deleteBank();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted('banks', ['id' => $bank->getKey()]);
    }

    public function test_can_update_the_bank(): void
    {

        $bank = BankFactory::new()->createOne([
            'holder_type' => $this->user->getMorphClass(),
            'holder_id' => $this->user->getKey(),
            'bank_id' => $this->bank->code,
        ]);

        $data = [
            'label' => 'primary',
            'account_holder' => $this->faker->name,
            'account_number' => $this->faker->creditCardNumber,
        ];

        $bankRepo = new BankRepository($bank);
        $updated = $bankRepo->updateBank($data);

        $bank = $bankRepo->getBank($data['account_number']);

        $this->assertTrue($updated);
        $this->assertEquals($data['label'], $bank->label);
        $this->assertEquals($data['account_holder'], $bank->account_holder);
        $this->assertEquals($data['account_number'], $bank->account_number);
    }

    public function test_can_create_a_bank(): void
    {
        $data = [
            'holder_type' => $this->user->getMorphClass(),
            'holder_id' => $this->user->getKey(),
            'bank_id' => $this->bank->code,
            'label' => 'primary',
            'account_holder' => $this->faker->name,
            'account_number' => $this->faker->randomNumber(9),
        ];

        $bankRepo = new BankRepository(new Bank);
        $bank = $bankRepo->createBank($data);

        $this->assertInstanceOf(Bank::class, $bank);
        $this->assertEquals($data['label'], $bank->label);
        $this->assertEquals($data['account_holder'], $bank->account_holder);
        $this->assertEquals($data['account_number'], $bank->account_number);
    }

    public function test_errors_creating_the_bank(): void
    {
        $this->expectException(Exception::class);

        $bankRepo = new BankRepository(new Bank);
        $bankRepo->createBank([]);
    }

    public function test_bank_has_relation(): void
    {
        $bank = BankFactory::new()->createOne([
            'holder_type' => $this->user->getMorphClass(),
            'holder_id' => $this->user->getKey(),
            'bank_id' => $this->bank->code,
        ]);

        $this->assertInstanceOf(Bank::class, $bank);
        $this->assertInstanceOf(User::class, $bank->holder);
        $this->assertInstanceOf(MorphTo::class, $bank->holder());
        $this->assertInstanceOf(\Turahe\Master\Models\Bank::class, $bank->bank);
        $this->assertInstanceOf(BelongsTo::class, $bank->bank());
    }
}
