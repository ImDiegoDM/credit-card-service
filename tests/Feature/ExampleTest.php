<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetPayment()
    {
        $response = $this->get('/api/v1/public/pagamentos/1');

        $response->assertStatus(200)->assertJson([
            'id' => 1,
            'user'=>[
                'id'=>0,
                'name'=>'Diego Matias de Oliviera',
                'cpf'=>'111.111.111-11'
            ],
            'numero_cartão'=> '1234567891112',
            'valor'=> '150',
            'pedidos_id'=> 1
        ]);
    }

    public function testPostPaymentSuccess()
    {
        $creditCard = [ 
            'numero_cartão'=> '1234567891112',
            'valor'=> '150',
            'pedidos_id'=> 1
        ];

        $response = $this->withHeaders([
            'Authorization' => '123',
        ])->json('POST', '/api/v1/public/pagamentos', $creditCard);

        $response->assertStatus(201)->assertJson([
            'id' => 1,
            'user'=>[
                'id'=>0,
                'name'=>'Diego Matias de Oliviera',
                'cpf'=>'111.111.111-11'
            ],
            'numero_cartão'=> '1234567891112',
            'valor'=> '150',
            'pedidos_id'=> 1
        ]);
    }

    public function testPostPaymentWhithoutHeader()
    {
        $creditCard = [ 
            'numero_cartão'=> '1234567891112',
            'valor'=> '150',
            'pedidos_id'=> 1
        ];

        $response = $this->json('POST', '/api/v1/public/pagamentos', $creditCard);

        $response->assertStatus(400)->assertJson(['message'=>'Authorization header is missing']);
    }
}
