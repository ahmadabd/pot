const Register = () => {

    return (
        <>
            <div>
                <h1>Register</h1>
                <form>
                    <div>
                        <label htmlFor="name">Name</label>
                        <input type="text" id="name" name="name" />
                    </div>
                    <div>
                        <label htmlFor="email">Email</label>
                        <input type="email" id="email" name="email" />
                    </div>
                    <div>
                        <label htmlFor="password">Password</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    <div>
                        <label htmlFor="confirm-password">Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" />
                    </div>
                    <button type="submit">Register</button>
                </form>
            </div>
        </>
    );
}

export default Register;