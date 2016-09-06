<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-8-14
 * Time: 下午9:49
 */

namespace BlogBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="CommentRepository")
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $postId;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $userId;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $referId;
	/**
	 * @ORM\Column(type="string")
	 */
	private $title;
	/**
	 * @ORM\Column(type="string")
	 */
	private $content;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $likeCount;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $dislikeCount;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updateAt;


	
}