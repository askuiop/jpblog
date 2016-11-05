<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-15
 * Time: 上午11:43
 */

namespace BlogBundle\Entity;


use BlogBundle\Doctrine\CreateAndUpdateAction;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PostCommentRepository")
 * @ORM\Table(name="post_comment")
 * @ORM\HasLifecycleCallbacks()
 */
class PostComment extends Base 
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(type="integer")
   */
  protected $id;

  /**
   * @var User
   * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\User")
   * @ORM\JoinColumn(fieldName="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @var Post
   * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Post", inversedBy="comments")
   * @ORM\JoinColumn(fieldName="post_id", referencedColumnName="id")
   */
  protected $post;

  /**
   * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\PostComment")
   * @ORM\JoinColumn(fieldName="referrer_id", referencedColumnName="id")
   */
  protected $referrer;

  /**
   * @ORM\Column(type="integer")
   */
  protected $depth = 0;

  /**
   * @ORM\Column(type="string")
   */
  protected $nickname;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $title;

  /**
   * @ORM\Column(type="string")
   */
  protected $content;

  /**
   * @ORM\Column(type="datetime")
   */
  protected $createdAt;

  /**
   * @ORM\Column(type="datetime")
   */
  protected $updatedAt;



  use CreateAndUpdateAction;


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
     * Set depth
     *
     * @param integer $depth
     *
     * @return PostComment
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return integer
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return PostComment
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
     * Set title
     *
     * @param string $title
     *
     * @return PostComment
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
     * @return PostComment
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
     * @return PostComment
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
     * @return PostComment
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
     * Set referrer
     *
     * @param \BlogBundle\Entity\PostComment $referrer
     *
     * @return PostComment
     */
    public function setReferrer(\BlogBundle\Entity\PostComment $referrer = null)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get referrer
     *
     * @return \BlogBundle\Entity\PostComment
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Set post
     *
     * @param \BlogBundle\Entity\Post $post
     *
     * @return PostComment
     */
    public function setPost(\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set user
     *
     * @param \BlogBundle\Entity\User $user
     *
     * @return PostComment
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
}
