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
    private \DateTime $startDate;

    /**
     * @ORM\Column(name="end_date", type="date", length=255)
     * @var string
     */
    private \DateTime $endDate;

    public function __construct() {}

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param  string  $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param  string  $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param  string  $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param  string  $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param  string  $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param  int  $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
