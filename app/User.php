<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use ElasticScoutDriverPlus\CustomSearch;
use ElasticScoutDriverPlus\Builders\QueryBuilderInterface;

final class SearchFormQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string
     */
    private $name;

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function buildQuery(): array
    {
        return [
            "match" => [
                "name" => [
                    "query" => $this->name,
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }
}

class User extends Authenticatable
{
    use Notifiable;
    use
        Searchable,
        CustomSearch;

    public function toSearchableArray()
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
        ];
    }

    public static function searchForm(): SearchRequestBuilder
    {
        return new SearchRequestBuilder(new static(), new SearchFormQueryBuilder());
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
