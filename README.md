# bigtree-blog

This is a blog extension for BigTreeCMS. In its current state it supports multiple blogs, authors and categories.

As of right now I have not figured out a way to make a class in an extension refer to another class within the same extension without modifying BigTree core. The autoloader does not appear to be set up to do that. For now, I have added the following code to custom/inc/bigtree/utils.php in the classAutoLoader function, right before the last unlink statement:

            // load classes from extensions regardless of the route
            $baseExtDir = SERVER_ROOT . "extensions";
            $extDirs = scandir($baseExtDir);
            foreach ($extDirs as $extDirCounter => $extDir) {
                $classDir = $baseExtDir . "/" . $extDir . "/classes";
                if (file_exists($classDir)) {
                    $classFiles = scandir($classDir);
                    foreach ($classFiles as $cFileCounter => $classFile) {
                        if (!in_array($classFile, array(".", ".."))) {
                            include_once($baseExtDir . "/" . $extDir . "/classes/" . $classFile);
                        }
                    }
                }
            }

This essentially loads every extensions' class files on every call. This is inefficient, so I'll have to figure out a different solution.
