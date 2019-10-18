<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture {
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager) {
      $this->createManyTmp(10, 'main_users', function ($i) use ($manager) {
        $user = new User();
        $user->setEmail($this->faker->safeEmail);
        $user->setFirstName($this->faker->firstName);
        if ($this->faker->boolean) {
          $user->setTwitterUsername($this->faker->userName);
        }
        $user->setPassword($this->passwordEncoder->encodePassword(
          $user,
          'pass'
        ));

        $apiToken1 = new ApiToken($user);
        $apiToken2 = new ApiToken($user);
        $manager->persist($apiToken1);
        $manager->persist($apiToken2);

        return $user;
      });

      $this->createManyTmp(3, 'admin_users', function ($i) use ($manager) {
        $user = new User();
        $user->setEmail(sprintf('admin%d@example.com', $i));
        $user->setFirstName($this->faker->firstName);
        $user->setRoles(['ROLE_ADMIN']);
        if ($this->faker->boolean) {
          $user->setTwitterUsername($this->faker->userName);
        }

        $user->setPassword($this->passwordEncoder->encodePassword(
          $user,
          'pass'
        ));

        $apiToken1 = new ApiToken($user);
        $apiToken2 = new ApiToken($user);
        $manager->persist($apiToken1);
        $manager->persist($apiToken2);
        return $user;
      });

      $manager->flush();
  }
}
