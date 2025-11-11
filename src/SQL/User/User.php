<?php

namespace SimoMarcGoebel\Blog\SQL\User;

class User
{
    public string $username;
    public string $email;
    public int $role;
    public string $profilePicture;

    public function __construct(string $username, string $email, string $role, ?string $profilePicture = "default.jpg"){
        if ($this->checkInput($username, $email, $role, $profilePicture))
        {
            $this->username = $username;
            $this->email = $email;
            $this->role = $this->checkRole($role);
            $this->profilePicture = $profilePicture ?? "default.jpg";
        }
    }
    private function checkInput(string $username, string $email, string|int $role, string $profilePicture): bool
    {
        if ($this->checkUsername($username) && $this->checkEmail($email) && $this->checkRole($role) && $this->checkProfilePicture($profilePicture))
        {
            return true;
        }
        return false;
    }
    private function checkUsername(string $username): bool{
        // TODO: Add a username check
        return true;
    }
    private function checkEmail(string $email): bool{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) // Checks if it is a valid email
        {
            return true;
        }
        return false;
    }
    private function checkRole(string|int $role): int{
        if (!is_int($role))
        {
            switch (mb_strtolower(trim($role))) // Text role to roleid conversion
            {
                case "admin":
                    $role = 1;
                    break;
                case "moderator":
                    $role = 2;
                    break;
                case "user":
                    $role = 3;
                    break;
                case "banned":
                    $role = 4;
                    break;
                default:
                    $role = 5;
                    break;
            }
        }
        else
        {
            if (!(1 <= $role && $role <= 5))
            {
                return 5;
            }
        }
        return $role;
    }
    private function checkProfilePicture(string $profilePic): bool{
        if ($profilePic === "default.jpg" || $profilePic === "default" || $profilePic === "missing.png"){
            return true;
        }
        elseif(is_file($profilePic))
        {
            return true;
        }
        else{
            return false;
        }
    }
}