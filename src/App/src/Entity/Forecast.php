<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *      name="forecast",
 *      indexes={
 *          @ORM\Index(name="search_idx", columns={"name", "email", "phone"}),
 *          @ORM\Index(name="date_search_idx", columns={"start_date", "end_date"}),
 *      }
 * )
 */
class Forecast implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(name="name", type="string", length=32)
     * @var string
     */
    private string $name;

    /**
     * @ORM\Column(name="city", type="string", length=200)
     * @var string
     */
    private string $city;

    /**
     * @ORM\Column(name="phone", type="string", length=32)
     * @var string
     */
    private string $phone;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @var string
     */
    private string $email;

    /**
     * @ORM\Column(name="start_date", type="date", length=255)
     * @var string
     */
    private string $startDate;

    /**
     * @ORM\Column(name="end_date", type="date", length=255)
     * @var string
     */
    private string $endDate;

    public function __construct(
        int $id,
        string $name,
        string $city,
        string $phone,
        string $email,
        string $startDate,
        string $endDate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->phone = $phone;
        $this->email = $email;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'phone' => $this->phone,
            'email' => $this->email,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}
