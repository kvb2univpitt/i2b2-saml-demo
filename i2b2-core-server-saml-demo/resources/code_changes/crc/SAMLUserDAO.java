package src.server.edu.harvard.i2b2.crc.dao;

import edu.harvard.i2b2.common.exception.I2B2Exception;
import edu.harvard.i2b2.crc.util.QueryProcessorUtil;
import javax.sql.DataSource;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 *
 * May 23, 2021 12:55:54 AM
 *
 * @author Kevin V. Bui (kvb2univpitt@gmail.com)
 */
public final class SAMLUserDAO {

    private static final Log LOGGER = LogFactory.getLog(SAMLUserDAO.class);

    public static String getLocalUser(String username) throws I2B2Exception {
        DataSource dataSource = QueryProcessorUtil.getInstance().getDataSource("java:/PMBootStrapDS");
        JdbcTemplate jdbcTemplate = new JdbcTemplate(dataSource);
        String query = "SELECT user_id FROM pm_user_params WHERE param_name_cd = 'eppn' AND lower(value) = lower(?)";
        try {
            return jdbcTemplate.query(
                    query,
                    ps -> ps.setString(1, username.replaceAll("saml:", "")),
                    rs -> rs.next() ? rs.getString(1) : username);
        } catch (DataAccessException exception) {
            LOGGER.error("Unable to lookup local username using SAML username.", exception);
            exception.printStackTrace(System.err);
        }

        return username;
    }

}

