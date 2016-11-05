<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-6-26
 * Time: 上午11:51
 */

namespace BlogBundle\Entity;


use BlogBundle\Doctrine\CreateAndUpdateAction;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="user")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "oauth" = "Oauth"})
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"account"}, message="Unique!")
 */
class User extends Base  implements AdvancedUserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank()
	 */
	protected $account;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $nickname;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;


  /**
   * @ORM\Column(type="string")
   */
  protected $avatar = '';

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  protected $gender;

  /**
   * @ORM\Column(type="string")
   */
  protected $phoneNumber = '';

  /**
   * @ORM\Column(type="string")
   */
  protected $addr = '';

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $updatedAt;

	/**
	 * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Post", mappedBy="user")
	 */
	protected $posts;


	/**
	 * @Assert\NotBlank(groups={"Registration"})
	 */
	protected $plainPassword;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->posts = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set account
	 *
	 * @param string $account
	 *
	 * @return User
	 */
	public function setAccount($account)
	{
		$this->account = $account;

		return $this;
	}

	/**
	 * Get account
	 *
	 * @return string
	 */
	public function getAccount()
	{
		return $this->account;
	}

	/**
	 * Set nickname
	 *
	 * @param string $nickname
	 *
	 * @return User
	 */
	public function setNickname($nickname)
	{
		$this->nickname = $nickname;

		return $this;
	}

	/**
	 * Get nickname
	 *
	 * @return string
	 */
	public function getNickname()
	{
		return $this->nickname;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 *
	 * @return User
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	 * Get createdAt
	 *
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * Set updatedAt
	 *
	 * @param string $updatedAt
	 *
	 * @return User
	 */
	public function setUpdatedAT($updatedAt)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Get updatedAt
	 *
	 * @return string
	 */
	public function getUpdatedAT()
	{
		return $this->updatedAt;
	}

	/**
	 * Add post
	 *
	 * @param \BlogBundle\Entity\Post $post
	 *
	 * @return User
	 */
	public function addPost(\BlogBundle\Entity\Post $post)
	{
		$this->posts[] = $post;

		return $this;
	}

	/**
	 * Remove post
	 *
	 * @param \BlogBundle\Entity\Post $post
	 */
	public function removePost(\BlogBundle\Entity\Post $post)
	{
		$this->posts->removeElement($post);
	}

	/**
	 * Get posts
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPosts()
	{
		return $this->posts;
	}


	/**
	 * @return mixed
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	/**
	 * @param mixed $plainPassword
	 */
	public function setPlainPassword($plainPassword)
	{
		$this->plainPassword = $plainPassword;
		$this->password = null;
	}

	public function getRoles()
	{
		return ["ROLE_USER"];
	}

	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	public function getUsername()
	{
		return $this->account;
	}

	public function eraseCredentials()
	{
		$this->plainPassword = null;
	}

  public function isAccountNonExpired()
  {
    return true;
  }

  public function isAccountNonLocked()
  {
    return true;
  }

  public function isCredentialsNonExpired()
  {
    return true;
  }

  public function isEnabled()
  {
    return true;
  }

  /**
   * @return mixed
   */
  public function getAvatar()
  {
    return $this->avatar;
  }

  /**
   * @param mixed $avatar
   */
  public function setAvatar($avatar)
  {
    $this->avatar = $avatar;
  }

  /**
   * @return mixed
   */
  public function getGender()
  {
    return $this->gender;
  }

  /**
   * @param mixed $gender
   */
  public function setGender($gender)
  {
    $this->gender = $gender;
  }

  /**
   * @return mixed
   */
  public function getPhoneNumber()
  {
    return $this->phoneNumber;
  }

  /**
   * @param mixed $phoneNumber
   */
  public function setPhoneNumber($phoneNumber)
  {
    $this->phoneNumber = $phoneNumber;
  }

  /**
   * @return mixed
   */
  public function getAddr()
  {
    return $this->addr;
  }

  /**
   * @param mixed $addr
   */
  public function setAddr($addr)
  {
    $this->addr = $addr;
  }


  //use CreateAndUpdateAction;





}
