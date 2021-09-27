<?php
/**
* @author Jhon Mike Soares <https://github.com/jhonmike>
*/

namespace Zf2User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;

/**
 * Perfil
 *
 * @ORM\Table(name="user_perfil")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Zf2User\Entity\PerfilRepository")
 */
class Perfil
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_birth", type="datetime", nullable=true)
     */
    private $dateBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="localization", type="string", length=255, nullable=true)
     */
    private $localization;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="obs", type="string", nullable=true)
     */
    private $obs;

    /**
     * @var \Zf2User\Entity\User
     *
     * @ORM\OneToOne(targetEntity="Zf2User\Entity\User", inversedBy="perfil")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id",onDelete="CASCADE", nullable=false)
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct(array $options = array())
    {
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->hydrate($options, $this);
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
     * Set name
     *
     * @param string $name
     * @return Perfil
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set dateBirth
     *
     * @param string $dateBirth
     * @return Perfil
     */
    public function setDateBirth($dateBirth)
    {
        $this->dateBirth = new \DateTime($dateBirth);

        return $this;
    }

    /**
     * Get dateBirth
     *
     * @return string
     */
    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    /**
     * Set localization
     *
     * @param string $localization
     * @return Perfil
     */
    public function setLocalization($localization)
    {
        $this->localization = $localization;

        return $this;
    }

    /**
     * Get localization
     *
     * @return string
     */
    public function getLocalization()
    {
        return $this->localization;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Perfil
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set obs
     *
     * @param string $obs
     * @return Perfil
     */
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    /**
     * Get obs
     *
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set user
     *
     * @param \Zf2User\Entity\User $user
     * @return Perfil
     */
    public function setUser(\Zf2User\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Zf2User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /*
     * toArray
     */
    public function toArray()
    {
        $hydrator = new Hydrator\ClassMethods();
        $array = $hydrator->extract($this);
        $array['date_birth'] = $this->getDateBirth()->format('d-m-Y');
        $array['user'] = $this->getUser()->getId();

        return $array;
    }
}
