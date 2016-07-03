<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-6-26
 * Time: 上午11:51
 */

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="string")
	 */
	private $account;
	/**
	 * @ORM\Column(type="string")
	 */
	private $nickname;
	/**
	 * @ORM\Column(type="string")
	 */
	private $mail;

	/**
	 * @ORM\Column(type="string")
	 */
	private $password;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updatedAt;

	/**
	 * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Post", mappedBy="user")
	 */
	private $posts;


	private $plainPassword;

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
	 * Set mail
	 *
	 * @param string $mail
	 *
	 * @return User
	 */
	public function setMail($mail)
	{
		$this->mail = $mail;

		return $this;
	}

	/**
	 * Get mail
	 *
	 * @return string
	 */
	public function getMail()
	{
		return $this->mail;
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
	}

	public function getRoles()
	{
		// TODO: Implement getRoles() method.
	}

	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	public function getUsername()
	{
		// TODO: Implement getUsername() method.
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}




	/**
	 * @ORM\PrePersist()
	 */
	public function prePersist()
	{
		if (empty($this->createdAt)) {
			$this->setCreatedAt(new \DateTime());
		}

		if (empty($this->updatedAt)) {
			$this->setUpdatedAt(new \DateTime());
		}


	}

	/**
	 * @ORM\PreUpdate()
	 */
	public function preUpdate()
	{
		$this->setUpdatedAt(new \DateTime());
	}



}
