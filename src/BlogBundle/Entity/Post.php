<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-6-26
 * Time: 上午8:44
 */

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use  BlogBundle\Doctrine\CreateAndUpdateAction;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="PostRepository")
 * @ORM\Table(name="post")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Post extends Base
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(groups={"new"});
	 * @Assert\Length(max="60",min="4",groups={"v_new_post"})
	 *
	 */
	private $title;

	/**
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(groups={"new"});
	 * @Assert\Length(max="400",min="20",groups={"v_new_post"})
	 */
	private $summary;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $thumbnail;

	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $tags;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank(groups={"v_new_post"});
	 *
	 */
	private $content;

	/**
	 * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\User", inversedBy="posts")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @var ArrayCollection
	 * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Category", mappedBy="posts")
	 *
	 */
	private $categories;

  /**
   * @ORM\OneToMany(targetEntity="BlogBundle\Entity\PostComment", mappedBy="post")
   *
   */
  private $comments;


	/**
	 * @ORM\Column(type="integer", nullable=true, options={"default":0})
	 */
	private $readCount = 0;

	/**
	 * @ORM\Column(type="integer", nullable=true, options={"default":0})
	 */
	private $commentsCount = 0;


	/**
	 * @ORM\Column(type="string", nullable=true, options={"default":0})
	 */
	private $priority = 0;


	/**
	 * @ORM\Column(type="string" )
	 */
	private $sourceType = self::SOURCE_FORM_WEB;

	/**
	 * @ORM\Column(type="boolean", nullable=true, options={"default":1})
	 */
	private $isVisible;

	/**
	 * @ORM\Column(type="boolean",nullable=true, options={"default":1})
	 */
	private $couldComment;


	/**
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;
	/**
	 * @ORM\Column(type="datetime")
	 */
	private $updatedAt;


	const SOURCE_FORM_WEB = 0;
	const SOURCE_FORM_OWER = 1;
	
	const FILE_SAVA_PATH = '/uploads/post';


	static $postSourceType = [
		'ower' => self::SOURCE_FORM_WEB,
		'web'  => self::SOURCE_FORM_OWER,
	];


	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->categories = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set title
	 *
	 * @param string $title
	 *
	 * @return Post
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set content
	 *
	 * @param string $content
	 *
	 * @return Post
	 */
	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Set createdAt
	 *
	 * @param \DateTime $createdAt
	 *
	 * @return Post
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
	 * @param \DateTime $updatedAt
	 *
	 * @return Post
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	/**
	 * Get updatedAt
	 *
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * Set user
	 *
	 * @param \BlogBundle\Entity\User $user
	 *
	 * @return Post
	 */
	public function setUser(\BlogBundle\Entity\User $user = null)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \BlogBundle\Entity\User
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Add category
	 *
	 * @param \BlogBundle\Entity\Category $category
	 *
	 * @return Post
	 */
	public function addCategory(\BlogBundle\Entity\Category $category)
	{
		$this->categories[] = $category;

		return $this;
	}

	/**
	 * Remove category
	 *
	 * @param \BlogBundle\Entity\Category $category
	 */
	public function removeCategory(\BlogBundle\Entity\Category $category)
	{
		$this->categories->removeElement($category);
	}

	/**
	 * Get categories
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCategories()
	{
		return $this->categories;
	}


	/**
	 * Set summary
	 *
	 * @param string $summary
	 *
	 * @return Post
	 */
	public function setSummary($summary)
	{
		$this->summary = $summary;

		return $this;
	}

	/**
	 * Get summary
	 *
	 * @return string
	 */
	public function getSummary()
	{
		return $this->summary;
	}

	/**
	 * Set tags
	 *
	 * @param string $tags
	 *
	 * @return Post
	 */
	public function setTags($tags)
	{
		$this->tags = $tags;

		return $this;
	}

	/**
	 * Get tags
	 *
	 * @return string
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * Set readCount
	 *
	 * @param integer $readCount
	 *
	 * @return Post
	 */
	public function setReadCount($readCount)
	{
		$this->readCount = $readCount;

		return $this;
	}

	/**
	 * Get readCount
	 *
	 * @return integer
	 */
	public function getReadCount()
	{
		return $this->readCount;
	}

	/**
	 * Set commentsCount
	 *
	 * @param integer $commentsCount
	 *
	 * @return Post
	 */
	public function setCommentsCount($commentsCount)
	{
		$this->commentsCount = $commentsCount;

		return $this;
	}

	/**
	 * Get commentsCount
	 *
	 * @return integer
	 */
	public function getCommentsCount()
	{
		return $this->commentsCount;
	}

	/**
	 * Set priority
	 *
	 * @param string $priority
	 *
	 * @return Post
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;

		return $this;
	}

	/**
	 * Get priority
	 *
	 * @return string
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * Set sourceType
	 *
	 * @param string $sourceType
	 *
	 * @return Post
	 */
	public function setSourceType($sourceType)
	{
		$this->sourceType = $sourceType;

		return $this;
	}

	/**
	 * Get sourceType
	 *
	 * @return string
	 */
	public function getSourceType()
	{
		return $this->sourceType;
	}

	/**
	 * Set isVisible
	 *
	 * @param boolean $isVisible
	 *
	 * @return Post
	 */
	public function setIsVisible($isVisible)
	{
		$this->isVisible = $isVisible;

		return $this;
	}

	/**
	 * Get isVisible
	 *
	 * @return boolean
	 */
	public function getIsVisible()
	{
		return $this->isVisible;
	}

	/**
	 * Set couldComment
	 *
	 * @param string $couldComment
	 *
	 * @return Post
	 */
	public function setCouldComment($couldComment)
	{
		$this->couldComment = $couldComment;

		return $this;
	}

	/**
	 * Get couldComment
	 *
	 * @return string
	 */
	public function getCouldComment()
	{
		return $this->couldComment;
	}

	/**
	 * Set thumbnail
	 *
	 * @param string $thumbnail
	 *
	 * @return Post
	 */
	public function setThumbnail($thumbnail)
	{
		$this->thumbnail = $thumbnail;

		return $this;
	}

	/**
	 * Get thumbnail
	 *
	 * @return string
	 */
	public function getThumbnail()
	{
		return $this->thumbnail;
	}




    /**
     * Add comment
     *
     * @param \BlogBundle\Entity\PostComment $comment
     *
     * @return Post
     */
    public function addComment(\BlogBundle\Entity\PostComment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \BlogBundle\Entity\PostComment $comment
     */
    public function removeComment(\BlogBundle\Entity\PostComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
