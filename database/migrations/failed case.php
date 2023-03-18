Warning: TTY mode is not supported on Windows platform.

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   FAIL  Tests\Feature\MerchantHttpTest
  ⨯ get status

   FAIL  Tests\Feature\OrderWebhookTest
  ⨯ process order

   FAIL  Tests\Feature\PayoutOrderJobTest
  ⨯ calls api
  ⨯ rolls back if exception thrown

   FAIL  Tests\Feature\Services\AffiliateServiceTest
  ⨯ register affiliate
  ⨯ register affiliate when email in use as merchant
  ⨯ register affiliate when email in use as affiliate

   FAIL  Tests\Feature\Services\MerchantServiceTest
  ⨯ create merchant
  ⨯ update merchant
  ✓ find merchant by email
  ✓ find merchant by email when none exists
  ✓ payout

   FAIL  Tests\Feature\Services\OrderServiceTest
  ⨯ process order
  ⨯ process duplicate order

  ---

  • Tests\Feature\MerchantHttpTest > get status
   ErrorException

  Undefined array key "count"

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\MerchantHttpTest.php:58
     54▕
     55▕         $response = $this->actingAs($this->merchant->user)
     56▕             ->json('GET', route('merchant.order-stats'), compact('from', 'to'));
     57▕
  ➜  58▕         $this->assertEquals($between->count(), $response['count']);
     59▕         $this->assertEquals($between->sum('subtotal'), $response['revenue']);
     60▕         $this->assertEquals($between->sum('commission_owed') - $noAffiliate->commission_owed, $response['commissions_owed']);
     61▕     }
     62▕ }

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\OrderWebhookTest > process order
  Expected response status code [200] but received 404.
  Failed asserting that 200 is identical to 404.

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\OrderWebhookTest.php:30
     26▕             ->with($data)
     27▕             ->once();
     28▕
     29▕         $this->post(route('webhook'), $data)
  ➜  30▕             ->assertOk();
     31▕     }
     32▕ }
     33▕

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\PayoutOrderJobTest > calls api
  Failed asserting that a row in the table [orders] matches the attributes {
      "id": 1,
      "payout_status": "paid"
  }.

  Found similar results: [
      {
          "id": 1,
          "merchant_id": 1,
          "affiliate_id": 1,
          "subtotal": 320.33,
          "commission_owed": 32.03,
          "payout_status": "unpaid",
          "discount_code": null,
          "created_at": "2023-03-09 15:18:00",
          "updated_at": "2023-03-09 15:18:00"
      }
  ].

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\PayoutOrderJobTest.php:44
     40▕         dispatch(new PayoutOrderJob($this->order));
     41▕
     42▕         $this->assertDatabaseHas('orders', [
     43▕             'id' => $this->order->id,
  ➜  44▕             'payout_status' => Order::STATUS_PAID
     45▕         ]);
     46▕     }
     47▕
     48▕     public function test_rolls_back_if_exception_thrown()

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\PayoutOrderJobTest > rolls back if exception thrown
  Failed asserting that exception of type "RuntimeException" is thrown.

  at C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
     94▕ unset($options);
     95▕
     96▕ require PHPUNIT_COMPOSER_INSTALL;
     97▕
  ➜  98▕ PHPUnit\TextUI\Command::main();
     99▕


  • Tests\Feature\Services\AffiliateServiceTest > register affiliate
   TypeError

  App\Services\AffiliateService::register(): Argument #1 ($data) must be of type array, App\Models\Merchant given, called in C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\Affil
iateServiceTest.php on line 49

  at C:\xampp\htdocs\assessment-task-master\app\Services\AffiliateService.php:18
     14▕ {
     15▕     public function __construct(
     16▕         protected ApiService $apiService
     17▕     ) {}
  ➜  18▕     function register(array $data)
     19▕     {
     20▕         $user = new User([
     21▕             'name' => $data['name'],
     22▕             'email' => $data['email'],

  1   C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\AffiliateServiceTest.php:49
      App\Services\AffiliateService::register(Object(App\Models\Merchant), "harvey.nyasia@yahoo.com", "Amparo Nitzsche V")

  2   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\Services\AffiliateServiceTest > register affiliate when email in use as merchant
  Failed asserting that exception of type "TypeError" matches expected exception "App\Exceptions\AffiliateCreateException". Message was: "App\Services\AffiliateService::register(): Argument #1
 ($data) must be of type array, App\Models\Merchant given, called in C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\AffiliateServiceTest.php on line 70" at
  C:\xampp\htdocs\assessment-task-master\app\Services\AffiliateService.php:18
  C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\AffiliateServiceTest.php:70
  .

  at C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
     94▕ unset($options);
     95▕
     96▕ require PHPUNIT_COMPOSER_INSTALL;
     97▕
  ➜  98▕ PHPUnit\TextUI\Command::main();
     99▕


  • Tests\Feature\Services\AffiliateServiceTest > register affiliate when email in use as affiliate
  Failed asserting that exception of type "TypeError" matches expected exception "App\Exceptions\AffiliateCreateException". Message was: "App\Services\AffiliateService::register(): Argument #1
 ($data) must be of type array, App\Models\Merchant given, called in C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\AffiliateServiceTest.php on line 82" at
  C:\xampp\htdocs\assessment-task-master\app\Services\AffiliateService.php:18
  C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\AffiliateServiceTest.php:82
  .

  at C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
     94▕ unset($options);
     95▕
     96▕ require PHPUNIT_COMPOSER_INSTALL;
     97▕
  ➜  98▕ PHPUnit\TextUI\Command::main();
     99▕


  • Tests\Feature\Services\MerchantServiceTest > create merchant
  Failed asserting that a row in the table [users] matches the attributes {
      "password": "fU;}WVV\/P%PQB",
      "email": "vbeahan@yahoo.com",
      "type": "merchant"
  }.

  Found: [
      {
          "id": 1,
          "name": "Matteo Morar",
          "email": "vbeahan@yahoo.com",
          "email_verified_at": null,
          "password": "$2y$04$HEMFV2E7r5pMWiS9QhXRM..oyh..ZvKz3czZu5ssecmDMt1\/14uJ6",
          "type": "merchant",
          "remember_token": null,
          "created_at": "2023-03-09 15:18:01",
          "updated_at": "2023-03-09 15:18:01"
      }
  ].

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\MerchantServiceTest.php:49
     45▕
     46▕         $this->assertDatabaseHas('users', [
     47▕             'password' => $data['api_key'],
     48▕             'email' => $data['email'],
  ➜  49▕             'type' => User::TYPE_MERCHANT
     50▕         ]);
     51▕     }
     52▕
     53▕     public function test_update_merchant()

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\Services\MerchantServiceTest > update merchant
  Failed asserting that a row in the table [merchants] matches the attributes {
      "id": 1,
      "domain": "lemke.info",
      "display_name": "Ms. Muriel Blick Jr."
  }.

  Found similar results: [
      {
          "id": 1,
          "user_id": 1,
          "domain": "bahringer.net",
          "display_name": "Clementina Parker",
          "turn_customers_into_affiliates": 1,
          "default_commission_rate": 0.1,
          "created_at": "2023-03-09 15:18:01",
          "updated_at": "2023-03-09 15:18:01"
      }
  ].

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\MerchantServiceTest.php:67
     63▕
     64▕         $this->assertDatabaseHas('merchants', [
     65▕             'id' => $merchant->id,
     66▕             'domain' => $data['domain'],
  ➜  67▕             'display_name' => $data['name']
     68▕         ]);
     69▕     }
     70▕
     71▕     public function test_find_merchant_by_email()

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\Services\OrderServiceTest > process order
  Failed asserting that a row in the table [orders] matches the attributes {
      "subtotal": 53.33,
      "affiliate_id": 1,
      "merchant_id": 1,
      "commission_owed": 26.665,
      "external_order_id": "bb8c6afc-ea8a-387e-938b-13ab9f73fa62"
  }.

  Found similar results: [
      {
          "id": 1,
          "merchant_id": 1,
          "affiliate_id": 2,
          "subtotal": 53.33,
          "commission_owed": 5.333,
          "payout_status": "unpaid",
          "discount_code": null,
          "created_at": "2023-03-09 15:18:01",
          "updated_at": "2023-03-09 15:18:01"
      }
  ].

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\OrderServiceTest.php:66
     62▕             'subtotal' => $data['subtotal_price'],
     63▕             'affiliate_id' => $affiliate->id,
     64▕             'merchant_id' => $this->merchant->id,
     65▕             'commission_owed' => $data['subtotal_price'] * $affiliate->commission_rate,
  ➜  66▕             'external_order_id' => $data['order_id']
     67▕         ]);
     68▕     }
     69▕
     70▕     public function test_process_duplicate_order()

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()

  • Tests\Feature\Services\OrderServiceTest > process duplicate order
  Failed asserting that table [orders] matches expected entries count of 1. Entries found: 2.
  .

  at C:\xampp\htdocs\assessment-task-master\tests\Feature\Services\OrderServiceTest.php:88
     84▕         ];
     85▕
     86▕         $this->getOrderService()->processOrder($data);
     87▕
  ➜  88▕         $this->assertDatabaseCount('orders', 1);
     89▕     }
     90▕ }
     91▕

  1   C:\xampp\htdocs\assessment-task-master\vendor\phpunit\phpunit\phpunit:98
      PHPUnit\TextUI\Command::main()


  Tests:  11 failed, 4 passed
  Time:   1.10s
